<?php

namespace GraphicalEditor;

/**
 * Editor Commands
 * @author  King James Torres <tcorp.kingjames@gmail.com>
 */
class GraphicalEditorService {

	/**
	 * [$image description]
	 * @var array
	 */
	protected $image = array();

	/**
	 * [$defaultColor description]
	 * @var string
	 */
	protected $defaultColor = 'O';

	/**
	 * [create Create the Image]
	 * @return [type] [description]
	 */
	public function create( $rows, $cols )
	{
		if( $isValid = $this->_validatePixels( $rows, $cols ) ) 
		{
			$image = array();
			$divider = array();

			for( $x = $rows; $x > 0; $x-- ) 
			{
				for( $y = $cols; $y > 0; $y-- ) 
				{
					// Initialize the image color to White (O)
					array_push( $divider, $this->defaultColor );
				}
				array_push( $image, $divider );
				$divider = array();
			}

			$this->image = $image;
			return true;
		}
		return false;
	}

	/**
	 * [setColor description]
	 * @param [type] $row   [description]
	 * @param [type] $col   [description]
	 * @param [type] $color [description]
	 */
	public function setColor( $row, $col, $color ) 
	{
		if( $this->_validatePixel( $row, $col ) ) 
		{
			$this->image[ $row - 1 ][ $col - 1 ] = $color;
		}
	}

	/**
	 * [_validatePixels description]
	 * @param  [type] $rows [description]
	 * @param  [type] $cols [description]
	 * @return [type]       [description]
	 */
	private function _validatePixels( $rows, $cols ) 
	{
		if( $cols >= 1 && ($rows <= 250 && $rows >= 1) ) 
		{
			return true;
		}
		return false;
	}

	private function _validatePixel( $row, $col ) 
	{
		if( isset( $this->image[ $row - 1 ][ $col - 1 ] ) ) 
		{
			return true;
		}
		return false;
	}
}