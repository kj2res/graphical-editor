<?php

/**
 * Graphical Editor Command Simulator
 * @author King James Torres <tcorp.kingjames@gmail.com>
 */

require_once 'vendor/autoload.php';

use GraphicalEditor\GraphicalEditorService;


class Simulator {

	/**
	 * [$exit Flag for Exiting the program]
	 * @var boolean
	 */
	protected $exit = false;

	/**
	 * [$editor description]
	 * @var [type]
	 */
	protected $editor;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->editor = new GraphicalEditorService();
	}

	/**
	 * [run Starts the program]
	 * @return [type] [description]
	 */
	public function run()
	{
		print "\n" . 'Graphical Editor Simulator' . "\n\n";

		do {

			/* Request input */
			print '> ';

			/* get the command */
			$input = trim( fgets( STDIN ) );

			// when X exit the program
			if ( strtoupper( $input ) === 'X' )
			{
				$this->exit = true;
				break;
			}

			$args = $this->_getInput( $input );
			$command = strtoupper( current($args) );

			switch ( $command ) {

				case 'I':

					if( $this->_isValidInput( $args, 3 ) ) 
						$this->editor->create( $args[1], $args[2] );
					else 
						print "Invalid Command. It should be 'I M N' \n";

					break;

				case 'L':

					if( $this->_isValidInput( $args, 4 ) ) 
						$this->editor->setColor( $args[1], $args[2], $args[3] );
					else
						print "Invalid Command. It should be 'L X Y C' \n";

					break;

				case 'S':

					if( $rows = $this->editor->showImage() ) 
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

					break;

				case 'C':

					$this->editor->clear();
					break;

				case 'F':

					if( $this->_isValidInput( $args, 4 ) )
						$this->editor->fillRegion( $args[1], $args[2], $args[3] );
					else
						print "Invalid Command. It should be 'F X Y C' \n";

					break;

				case 'V':

					if( $this->_isValidInput( $args, 5 ) )
						$this->editor->setVerticalSegment( $args[1], $args[2], $args[3], $args[4] );
					else
						print "Invalid Command. It should be 'V X Y1 Y2 C' \n";

					break;

				case 'H':

					if( $this->_isValidInput( $args, 5 ) )
						$this->editor->setHorizontalSegment( $args[1], $args[2], $args[3], $args[4] );
					else 
						print "Invalid Command. It should be 'H X1 X2 Y C' \n";

					break;

				default:
					break;
			}

		} while( !$this->exit );

		print 'Exiting..'."\n";
		exit;
	}

	/**
	 * [getInput Get the input]
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	private function _getInput( $input )
	{
		return explode( ' ', $input );
	}

	/**
	 * [_isValidInput checking parameters]
	 * @param  [type]  $args   [description]
	 * @param  [type]  $length [description]
	 * @return boolean         [description]
	 */
	private function _isValidInput( $input, $length )
	{
		if( count( $input ) !== $length ) {
			return false;
		}
		return true;
	}
}

/**
 * Running the simulator
 */
$simulator = new Simulator();
$simulator->run();