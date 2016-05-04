<?
	
	$memberList = $_POST ["memberList"];
	unset($memberList[0]);
	foreach($memberList as $member){
		$sql .= " OR MemberID = " . $member;
	}
	echo $selectMember . "</br>";
?>