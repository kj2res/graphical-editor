<?php

/**
 * Graphical Editor Command Demo
 * @author King James Torres <tcorp.kingjames@gmail.com>
 */

require_once 'vendor/autoload.php';

use GraphicalEditor\GraphicalEditorService;

/**
 * [$exit Flag for Exiting the program]
 * @var integer
 */
$exit = 0;
	
/**
 * [getArgs Get the Inputs]
 * @param  [type] $input [description]
 * @return [type]        [description]
 */
function getArgs( $input ) 
{
	return explode( ' ', $input );
}

/**
 * [isValidParams checking parameters]
 * @param  [type]  $args   [description]
 * @param  [type]  $length [description]
 * @return boolean         [description]
 */
function isValidParams( $args, $length ) 
{
	if( count( $args ) !== $length ) {
		return false;
	}
	return true;
}

$editor = new GraphicalEditorService();

print "\n" . 'Graphical Editor Simulator' . "\n";

while( !$exit ) 
{

	/* Request input */
	print '> ';

	/* get the command */
	$input = trim( fgets( STDIN ) );

	// when X exit the program
	if ( strtoupper( $input ) === 'X' )
	{
		$exit++;
		break;
	}

	$args = getArgs( $input );
	$command = strtoupper( current($args) );

	if( $command === 'I' ) 
	{	
		if( isValidParams( $args, 3 ) ) 
		{
			$editor->create( $args[1], $args[2] );
		}
		else 
		{
			print "Invalid Command. It should be 'I M N' \n";
		}
	}
	else if( $command === 'L' ) 
	{
		if( isValidParams( $args, 4 ) ) 
		{
			$editor->setColor( $args[1], $args[2], $args[3] );
		}
		else
		{
			print "Invalid Command. It should be 'L X Y C' \n";
		}
		
	}
	else if( $command === 'S' ) 
	{
		if( $rows = $editor->showImage() ) 
		{
			foreach ( $rows as $row ) 
			{
				foreach ( $row as $col ) 
				{
					print $col;
				}
				print "\n";
			}
		}
		else {
			print 'No image created' . "\n";
		}
	}
	else if( $command === 'C' ) 
	{
		$editor->clear();
	}
	else if( $command === 'F' ) 
	{
		if( isValidParams( $args, 4 ) )
		{
			$editor->fillRegion( $args[1], $args[2], $args[3] );
		}
		else
		{
			print "Invalid Command. It should be 'F X Y C' \n";
		}
	}
	else if( $command === 'V' )
	{
		if( isValidParams( $args, 5 ) )
		{
			$editor->setVerticalSegment( $args[1], $args[2], $args[3], $args[4] );
		}
		else
		{
			print "Invalid Command. It should be 'V X Y1 Y2 C' \n";
		}
	}
	else if( $command === 'H' )
	{
		if( isValidParams( $args, 5 ) )
		{
			$editor->setHorizontalSegment( $args[1], $args[2], $args[3], $args[4] );
		}
		else 
		{
			print "Invalid Command. It should be 'H X1 X2 Y C' \n";
		}
	}
}

print 'Bye'."\n";
exit;