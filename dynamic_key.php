<?php

class DynamicKey{
	$key_file = "dynamic_key/ServerKey";
	$date_file = "dynamic_key/KeyDate";
	$date_format = "F j, Y, g:i a";
	$key_life = "-1 hours";

	/*
	 *	Generate a random sequence of characters to be used for the key
	 *	@param int $length 		length of string
	 *	@return string $key 	randomly generated key
	 *	
	 */
	function generateKeystring($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $key;
	}

	/*
	 *	Calls method to generate key and then stores the key in specified file,
	 *	along with a timestamp.
	 * 	@return string $key 	randomly generated key from generateKeystring()
	 */
	function storeNewKey() {
		$key = generateKeystring();
		$time = date($this->date_format);
		file_put_contents($key_file, $key);
		file_put_contents($date_file, $time);
		return $key;
	}

	/*
	 *	Tries to find a recent key on the server. If the key doesn't exist or 
	 *	if it is out of date, it will be replaced with a new one
	 *
	 *	@return string $key 	randomly generated key, or recent key
	 */
	function retrieveKey() {
		if (file_exists($this->keyfile) && file_exists($this->date_file)) {
			$date = strtotime(file_get_contents($this->date_file));
			$key_life = strtotime($this->key_life);
			if ($date < $key_life) {
				return storeNewKey();
			} else {
				$key = file_get_contents($this->keyfile);
				return $key;
			}
		} else {
		 	$key = storeNewKey();
			return $key;
		}
	}

	/*
	 * Change the default Key file location
	 * @param string $file_location
	 * 
	 *	@return $this
	 */
	function setKeyFile($file_location) {
		if (!is_string($file_location)) {
			throw new Exception("Invalid File Location");
		} else {
			$this->key_file = $file_location;
			return $this;
		}
	}

	/*
	 * Change the default Date file location
	 * @param string $file_location
	 * 
	 *	@return $this
	 */
	function setDateFile($file_location) {
		if (!is_string($file_location)) {
			throw new Exception("Invalid File Location");
		} else {
			$this->date_file = $file_location;
			return $this;
		}
	}

	/*
	 * Change the default timestamp_format
	 * @param string $date_format 	Example: "F j, Y, g:i a"
	 * 
	 *	@return $this
	 */
	function setDateFormat($date_format) {
		if (!(bool)strtotime($date_format)) {
			throw new Exception("Invalid Date Format");
		} else {
			$this->date_format = $date_format;
			return $this;
		}
	}

	/*
	 * Set key life
	 * @param string $key_life	string representation of key life. A key life of
	 							1 hour should be represented as "-1 hours"
	 * 
	 *	@return $this
	 */
	function setKeyLife($key_life) {
		if (!(bool)strtotime($key_life)) {
			throw new Exception("Invalid Timestamp");
		} else {
			$this->key_life = $key_life;
			return $this;
		}
	}

}
