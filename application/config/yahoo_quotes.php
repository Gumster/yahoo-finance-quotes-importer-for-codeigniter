<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| Configuration for yahoo_quotes 
*/

$config = array();

// target table name
$config['table_name'] = 'yahoo_quotes';

/* SYMBOLS
| exchange symbols to be queried
| Commodity is matched to an exchange
*/
$config['symbols'] = array(
			'C' => 'CBT',
			'RR' => 'CBT',
			'S' => 'CBT',			
			'SB' => 'NYB',			
			'SM' => 'CBT'
		);

/* CONTRACT DAY
|  The day the contract is due per month 
*/
$config['contract_day'] = 15;

/* CONTRACT MONTHS
|
*/
$config['month_symbols'] = array(
			'1' => 'F',
			'2' => 'G',
			'3' => 'H',
			'4' => 'J',
			'5' => 'K',
			'6' => 'M',
			'7' => 'N',
			'8' => 'Q',
			'9' => 'U',
			'10' => 'V',
			'11' => 'X',
			'12' => 'Z',
			'Cash' => 'Y'		
		);
		
/* DELIVERY MONTHS
| Commodities have fixed delivery months
*/
$config['delivery_months'] = array(
			'C' => 'H,K,N,U,Z',
			'RR' => 'F,H,K,N,U,X',
			'S' => 'F,H,K,N,Q,U,X',			
			'SB' => 'H,K,N,V',
			'SM' => 'F,H,K,N,Q,U,V,Z'
		);
		
/* OPTIONS
| See following url for option definitions
| http://code.google.com/p/yahoo-finance-managed/wiki/enumQuoteProperty
| all_options array maps field names to option 'tag' eg 'a0'
|
| NB There seem to be more CSV options / fields than are present
| in YQL XML/JSON response (87 CSV vs 81 YQL)
*/
$config['all_options'] = array(
            'AfterHoursChangeRealtime' => 'c8',
            'AnnualizedGain' => 'g3',
            'Ask' => 'a0',
            'AskRealtime' => 'b2',
            'AskSize' => 'a5',
            'AverageDailyVolume' => 'a2',
            'Bid' => 'b0',	
            'BidRealtime' => 'b3',
            'BidSize' => 'b6',	
            'BookValuePerShare' => 'b4',
            'Change' => 'c1',
            'Change_ChangeInPercent' => 'c0',
            'ChangeFromFiftydayMovingAverage' => 'm7',
            'ChangeFromTwoHundreddayMovingAverage' => 'm5',
            'ChangeFromYearHigh' => 'k4',
            'ChangeInPercent' => 'p2',
            'ChangeInPercentRealtime' => 'k2',
            'ChangeRealtime' => 'c6',	
            'Commission' => 'c3',	
            'Currency' => 'c4',	
            'DaysHigh' => 'h0',	
            'DaysLow' => 'g0',	
            'DaysRange' => 'm0',
            'DaysRangeRealtime' => 'm2',
            'DaysValueChange' => 'w1',
            'DaysValueChangeRealtime' => 'w4',
            'DividendPayDate' => 'r1',
            'TrailingAnnualDividendYield' => 'd0',
            'TrailingAnnualDividendYieldInPercent' => 'y0',
            'DilutedEPS' => 'e0',
            'EBITDA' => 'j4',
            'EPSEstimateCurrentYear' => 'e7',
            'EPSEstimateNextQuarter' => 'e9',
            'EPSEstimateNextYear' => 'e8',
            'ExDividendDate' => 'q0',
            'FiftydayMovingAverage' => 'm3',
            'SharesFloat' => 'f6',
            'HighLimit' => 'l2',
            'HoldingsGain' => 'g4',
            'HoldingsGainPercent' => 'g1',
            'HoldingsGainPercentRealtime' => 'g5',
            'HoldingsGainRealtime' => 'g6',
            'HoldingsValue' => 'v1',
            'HoldingsValueRealtime' => 'v7',
            'LastTradeDate' => 'd1',
            'LastTradePriceOnly' => 'l1',
            'LastTradeRealtimeWithTime' => 'k1',
            'LastTradeSize' => 'k3',
            'LastTradeTime' => 't1',
            'LastTradeWithTime' => 'l0',
            'LowLimit' => 'l3',
            'MarketCapitalization' => 'j1',
            'MarketCapRealtime' => 'j3',
            'MoreInfo' => 'i0',
            'Name' => 'n0',
            'Notes' => 'n4',
            'OneyrTargetPrice' => 't8',
            'Open' => 'o0',
            'OrderBookRealtime' => 'i5',
            'PEGRatio' => 'r5',
            'PERatio' => 'r0',
            'PERatioRealtime' => 'r2',
            'PercentChangeFromFiftydayMovingAverage' => 'm8',
            'PercentChangeFromTwoHundreddayMovingAverage' => 'm6',
            'ChangeInPercentFromYearHigh' => 'k5',
            'PercentChangeFromYearLow' => 'j6',
            'PreviousClose' => 'p0',
            'PriceBook' => 'p6',
            'PriceEPSEstimateCurrentYear' => 'r6',
            'PriceEPSEstimateNextYear' => 'r7',
            'PricePaid' => 'p1',
            'PriceSales' => 'p5',
            'Revenue' => 's6',
            'SharesOwned' => 's1',
            'SharesOutstanding' => 'j2',
            'ShortRatio' => 's7',
            'StockExchange' => 'x0',
            'Symbol' => 's0',
            'TickerTrend' => 't7',
            'TradeDate' => 'd2',
            'TradeLinks' => 't6',
            'TradeLinksAdditional' => 'f0',
            'TwoHundreddayMovingAverage' => 'm4',
            'Volume' => 'v0',
            'YearHigh' => 'k0',
            'YearLow' => 'j0',
            'YearRange' => 'w0'
        );
// csv response
$config['csv_url'] = 'http://download.finance.yahoo.com/d/quotes.csv?e=.csv';
// alternative YQL url
$config['yql_url'] = 'http://query.yahooapis.com/v1/public/yql?env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
// YQL query table
$config['yql_query_source'] = 'yahoo.finance.quotes';


/* End of file yahoo_quotes.php */
/* Location: ./application/config/yahoo_quotes.php */