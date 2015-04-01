<?php

/**
 * Graphical Editor Command Demo
 * @author King James Torres <tcorp.kingjames@gmail.com>
 */

require_once 'vendor/autoload.php';

use GraphicalEditor\GraphicalEditorService;

$exit = 0;

function getArgs( $input ) {
	return explode( ' ', $input );
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
		$editor->create( $args[1], $args[2] );
	}
	else if( $command === 'L' ) 
	{
		$editor->setColor( $args[1], $args[2], $args[3] );
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
	}
	else if( $command === 'C' ) 
	{
		$editor->clear();
	}
	else if( $command === 'F' ) 
	{
		$editor->fillRegion( $args[1], $args[2], $args[3] );
	}
	else if( $command === 'V' )
	{
		$editor->setVerticalSegment( $args[1], $args[2], $args[3], $args[4] );
	}
	else if( $command === 'H' )
	{
		$editor->setHorizontalSegment( $args[1], $args[2], $args[3], $args[4] );
	}
}

print 'Bye'."\n";
exit;