use GD::Simple;
use strict;

my $width = shift;
my $height = shift;

my $xmin = shift;

my $im = GD::Simple->new($width, $height);
$im->bgcolor(255, 255, 255);
$im->clear();

$im->fgcolor(0, 0, 50);

my $adj = -1;
my $x = shift;
my $y = shift;
while(@ARGV){
    $im->moveTo($x, $y + $adj);
    $im->lineTo($xmin - 10, $y + $adj);
    $x = shift(@ARGV);
    $y = shift(@ARGV);
    $im->lineTo($xmin - 10, $y + $adj);
}
$im->lineTo($x, $y + $adj);

$im->moveTo(0, $y);

print $im->png;
