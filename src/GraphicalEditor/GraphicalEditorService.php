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
	 * [setColor Sets the color of the specified Pixel Coordinate]
	 * @param [int] $row   [ pixelX ]
	 * @param [int] $col   [ pixelY ]
	 * @param [string] $color [ The Color to be set ]
	 */
	public function setColor( $row, $col, $color ) 
	{
		if( $this->_validatePixel( $row, $col ) ) 
		{
			$this->image[ $row - 1 ][ $col - 1 ] = $color;
		}
	}

	/**
	 * [setVerticalSegment Creates Vertical Segment]
	 * @param [type] $row   [description]
	 * @param [type] $col1  [description]
	 * @param [type] $col2  [description]
	 * @param [type] $color [description]
	 */
	public function setVerticalSegment( $row, $col1, $col2, $color ) 
	{
		if( $this->_validatePixel( $row, $col1 ) && $this->_validatePixel( $row, $col2 ) ) 
		{
			$this->image[ $row - 1 ][ $col1 - 1 ] = $color;
			$this->image[ $row - 1 ][ $col2 - 1 ] = $color;
		}
	}

	/**
	 * [setHorizontalSegment Creates Horizontal Segment]
	 * @param [type] $col1  [description]
	 * @param [type] $col2  [description]
	 * @param [type] $row   [description]
	 * @param [type] $color [description]
	 */
	public function setHorizontalSegment( $col1, $col2, $row, $color ) 
	{
		if( $this->_validatePixel( $row, $col1 ) && $this->_validatePixel( $row, $col2 ) ) 
		{
			$this->image[ $row - 1 ][ $col1 - 1 ] = $color;
			$this->image[ $row - 1 ][ $col2 - 1 ] = $color;
		}
	}

	/**
	 * [clear Reset the Image]
	 * @return [type] [description]
	 */
	public function clear() 
	{
		array_walk_recursive( $this->image, function( &$value, $key ) {
			$value = $this->defaultColor;
		});
	}

	/**
	 * [_validatePixels Check if the range of pixels is valid]
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

	/**
	 * [_validatePixel Check if specified pixel coordinate exist]
	 * @param  [type] $row [ pixelX ]
	 * @param  [type] $col [ pixelY ]
	 * @return [boolean]
	 */
	private function _validatePixel( $row, $col ) 
	{
		if( isset( $this->image[ $row - 1 ][ $col - 1 ] ) ) 
		{
			return true;
		}
		return false;
	}

	/**
	 * [showImage Get the Image]
	 * @return array The image
	 */
	public function showImage() 
	{
		return $this->image;
	}
}