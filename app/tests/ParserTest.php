<?php

class ParserTest extends TestCase {

	public function testParse()
	{

		/*$parser = new Parser();
		$parsed = parser->xml('~/branches.xml');
		echo $parsed;*/

		/*
		['BranchInfo'] = main branch array
		['BranchInfo'][x] = accessing branch 'x''s info
		
		locaton info:

		['BranchInfo'][x]['Address']
		['BranchInfo'][x]['ZipCode']
		['BranchInfo'][x]['Coordinates']['Latitude']
		['BranchInfo'][x]['Coordinates']['Longitude']

		name info:
		['BranchInfo'][x]['Name']
		['BranchInfo'][x]['ShortName'] # this is just the neighborhood, rather than neighborhood and branch

		identifier (their branch id):
		['BranchInfo'][x]['BranchId']

		*/
		$xml = file_get_contents('app/database/branches.xml');
		$parsed = Parser::xml($xml);
		# print_r($parsed['BranchInfo']);
		foreach($parsed['BranchInfo'] as $branchinfo) {

			$branchID = $branchinfo['BranchId'];
			$branchName = $branchinfo['Name'];
			$branchAddress = $branchinfo['Address'];
			$branchZip = $branchinfo['ZipCode'];
			$branchLocation = $branchAddress." ".$branchZip;

			echo "\xA".$branchID."\t".$branchName."\t".$branchLocation;

		}


	}

}

