#!/usr/bin/perl

use strict;
use warnings;

print STDOUT "\n\n";
print STDOUT "===================================================================================\n";
print STDOUT "|                                  MAFFT v6.864                                   |\n"; 
print STDOUT "===================================================================================\n";

#======================================================
#= VERIFICATION DES ARGUMENTS DE LA LIGNE DE COMMANDE
#======================================================
my $options = "";
my $date_debut = `date`;
my $nextValue = 0;
my $N = 0;

foreach my $option (@ARGV){
	if($nextValue == 1){
		$N = $option;
		$nextValue=0;
	}
	$options .= " " . $option; 
	if ($option eq "-N"){
		$nextValue=1;
	}
}

print STDOUT "cmd=bin/mafft $options";
&execute("bin/mafft $options > log_mafft.txt");



# if(($N > 0) && (-e "RAxML_bestTree.trex") && (-e "RAxML_bootstrap.trex")){
# 	$options =~ s/-f [a-z]/-f b/;
# 	$options =~ s/-n trex/-n BS_TREE/;
# 	$options =~ s/-N [0-9]*//;
# 	$options =~ s/-x [0-9]*//;
# 	$options =~ s/-b [0-9]*//;
# 	
# 	&execute("echo \"Add confidence Values : \" >> log.txt");
# 	&execute("echo \"./raxmlHPC $options -t RAxML_bestTree.trex -z RAxML_bootstrap.trex -n BS_TREE\" >> log.txt");
# 	&execute("./raxmlHPC $options -t RAxML_bestTree.trex -z RAxML_bootstrap.trex -n BS_TREE >> log.txt");
# }


my $status_mail = "ko";
# #=========================== envoie du mail =============================
if( -e "mafft.aln"){ 	
	$status_mail = "ok";
}
&envoie_mail($status_mail);
exit;


#=====================================================================================================
#= SOUS PROGRAMMES
#=====================================================================================================
sub envoie_mail{
	my $status = $_[0];
	my $date_fin = `date`;
	print STDOUT "\nenvoie du mail";

	my $mail = "";
	my $rep_mail = "";
	my $subject = "Trex : Result for RAxML";
	open IN , "cmdrc" || die ($!);
	while( my $ligne = <IN>){
		chomp($ligne);
		if($ligne =~ /mail/){
			(my $tmp,$mail) = split("=",$ligne);
			print STDOUT "\n$tmp,$mail";
		}
		if($ligne =~ /rep_mail/){
			(my $tmp,$rep_mail) = split("=",$ligne);
		}
	}
	close IN;

	open OUT, ">message_mail.txt" || die ($!);
	print OUT "Results for MAFFT 7.2.6\n\nThe results of your computation are now available (the data will be available for 7 days from now) :";
	print OUT "\nhttp://www.trex.uqam.ca/loadData.php?actionTrex=mafftresult&id=$rep_mail&status=$status";
	print OUT "\n\nComputation started at: $date_debut";
	print OUT "Computation ended at:  $date_fin";
	print OUT "\n\n The T-REX Web Server team";
	close OUT;
	#print STDOUT "\n/usr/local/bin/php /home/trex/public_html/scripts/sendmail.php $mail message_mail.txt";
	&execute("/usr/bin/php /home/trex/public_html/scripts/sendmail.php $mail message_mail.txt");
}

sub execute{
	my $cmd = $_[0];
	my $retour = system("$cmd");
}

