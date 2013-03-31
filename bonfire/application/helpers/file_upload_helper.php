<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	Copyright (c) 2011 Ronnie Loc NGUYEN

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

/*
	File: File Upload Helper

	Provides various helper functions when working with file upload in forms.
*/

if ( ! function_exists('file_upload_image'))
{
	function file_upload_image( $file_info, $field_name, $folder_name, $width = '', $height = '', $type = 0 ) {
		$error = "";
		$msg = "";
		$file_element_name = $field_name;
		if ( !empty( $file_info[$file_element_name]['error'] ) ) {
			switch( $file_info[$file_element_name]['error'] ) {
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		} elseif ( empty($file_info[$file_element_name]['tmp_name']) || $file_info[$file_element_name]['tmp_name'] == 'none' ) {
			$error = 'No file was uploaded..';
		} else {
			$file_name = explode( ".", $file_info[$file_element_name]['name']);
			$new_name = date("YmdHsi.") . $file_name[count( $file_name )-1];
			$_FILES[$file_element_name]['name'] = $new_name;

			$config['upload_path'] = './assets/images/'.$folder_name.'/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 2048;
			$config['max_width']  = '1280';
			$config['max_height']  = '1024';
			$ci =& get_instance();
			$ci->load->library('upload', $config);
			$data = $ci->upload->do_upload($file_element_name);

			if ( !$data ) {
				$error = $ci->upload->display_errors();
			} else {
				// file upload successfully
				if ( !empty( $width ) && !empty( $height ) ) {
					$source_image = './assets/images/'.$folder_name.'/'.$new_name;
					$ci->load->library('image_lib', $config);
					$source_image_info = $ci->image_lib->get_image_properties( $source_image, true );

					$newwidth = $width; // This can be a set value or a percentage of original size ($width)
					$newheight = $height;
					$ratew = $source_image_info['width']/$newwidth;
					$rateh = $source_image_info['height']/$newheight;
					if ( $ratew < $rateh ) {
						$newheight = $source_image_info['height']/$ratew;
					} else {
						$newwidth = $source_image_info['width']/$rateh;
					}
					$config['image_library'] = 'gd2';
					$config['source_image'] = $source_image;
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = $newwidth;
					$config['height'] = $newheight;
					$thumb_marker = sprintf("_%dx%d", $width, $height);
					$config['thumb_marker'] = $thumb_marker;
					$ci->image_lib->initialize($config);
					$ci->image_lib->resize();

					$source_image = './assets/images/'.$folder_name.'/'.str_replace(".", $thumb_marker.'.', $new_name);
					$config['source_image'] = $source_image;
					$config['maintain_ratio'] = FALSE;
					$config['create_thumb'] = FALSE;
					$config['width'] = $width;
					$config['height'] = $height;
					$ci->image_lib->initialize($config);
					$ci->image_lib->crop();
				}
			}
			//for security reason, we force to remove all uploaded file
			@unlink($file_info[$file_element_name]);
		}
		$result = array();
		if ( empty( $error ) ) {
			$result["data"] = $_FILES[$file_element_name]['name'];
		} else {
			$result["error"] = $error;
		}

		return $result;
	}
}

if ( ! function_exists('delete_file_upload'))
{
	function delete_file_upload( $path, $ori_img='' ) {
		// Directories to ignore when listing output. Many hosts
		// will deny PHP access to the cgi-bin.
		$ignore = array( 'cgi-bin', '.', '..' );

		// Open the directory to the handle $dh
		$dh = @opendir( $path );
		// Loop through the directory
		while( false !== ( $file = readdir( $dh ) ) ){
			// Check that this file is not to be ignored
			if( !in_array( $file, $ignore ) ) {
				// Its a directory, so we need to keep reading down..
				if( !is_dir( "$path/$file" ) ) {
					$pos = strpos($file, $ori_img);
					if ( $pos !== false ) {
						@unlink("$path/$file");
					}
				}
			}
			//unlink($this->data['dir']['original'].$ori_img);
			//unlink($this->data['dir']['thumb'].'thumb_'.$ori_img);
		}
		// Close the directory handle
		closedir( $dh );
	}
}

