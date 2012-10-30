<?php

if( !defined('IN_APP') ) { die('DANGER WILL ROBINSON'); }

/**
 * Dashboard
 * 
 * This will manage and manipulate all of the dashboard functions
 * 
 * @author Marco Ceppi <marco@ceppi.net>
 * @package Portal
 * @subpackage Controller
 */
class Dashboard extends App
{
	/**
	 * Dashboard Init
	 * 
	 * @retun null
	 */
	public static function init()
	{
		static::view();
	}
	
	/**
	 * Dashboard View
	 * 
	 * @return null
	 */
	public static function view()
	{
		$more = TRUE;
		$page = $total = 0;
		$days = $tags = array();
		$tagged = str_replace(' ', '', HTTP::data('tagged'));
		$fromdate = (HTTP::data('from')) ? HTTP::data('from') : date('Y/m/d', strtotime('-1 month'));
		$todate = (HTTP::data('to')) ? HTTP::data('to') : date('Y/m/d', strtotime('now'));

		if( !empty($todate) && !empty($fromdate) && !empty($tagged) )
		{
			while($more)
			{
				$page++;
				$query = 'http://api.stackexchange.com/2.0/questions?pagesize=99&fromdate=' . strtotime($fromdate) . '&todate=' . (strtotime($todate) + 86400) . '&order=asc&sort=creation&tagged=' . $tagged . '&site=askubuntu&key=' . API_KEY . '&page=' . $page;

				$questions_compressed = file_get_contents($query);
				$questions_raw = gzinflate(substr($questions_compressed, 10, -8));
				$questions_decoded = json_decode($questions_raw, true);

				$questions = $questions_decoded['items'];
				$more = $questions_decoded['has_more'];
				$backoff = (array_key_exists('backoff', $questions_decoded)) ? $questions_decoded['backoff'] : FALSE;

				foreach( $questions as $question )
				{
					$date = date('Y-m-d', $question['creation_date']);
					if( !array_key_exists($date, $days) )
					{
						$days[$date] = 0;
					}

					$days[$date]++;
					foreach( $question['tags'] as $tag )
					{
						if( !array_key_exists($tag, $tags) )
						{
							$tags[$tag] = 1;
						}
						else
						{
							$tags[$tag]++;
						}
					}
					$total++;
				}

				if( $backoff )
				{
					sleep($backoff + 1);
				}
			}

			arsort($tags);
			unset($tags[$tagged]);

			static::$View->assign('tags', $tags);
			static::$View->assign('questions', $questions);
			static::$View->assign('JS', static::view_js($days, $tags, $fromdate, $todate));
		}

		static::$View->assign('fromdate', $fromdate);
		static::$View->assign('todate', $todate);
		static::$View->assign('tagged', $tagged);
		static::$View->display('view.tpl');
	}

	public static function view_js($days, $tags, $from, $to)
	{
		static::$View->assign('days', $days);
		static::$View->assign('fromdate', $from);
		static::$View->assign('todate', $to);
		static::$View->assign('tags', array_slice($tags, 0, 8, true));
		static::$View->assign('all_tags', $tags);
		return static::$View->fetch('view.js.tpl');
	}
}
