<?php

if (!defined('DATATABLES')) exit();


class Validate {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal functions
	 */

	/**
	 * "Magic" method to automatically apply the required check to any of the
	 * static methods simply by adding '_required' or '_empty' to the end of the
	 * method's name, depending on if you need the field to be submitted or not.
	 *
	 * This is retained for backwards compatibility, but the validation options
	 * are now the recommended way of indicating that a field is required.
	 *
	 *  @internal
	 */
	public static function __callStatic( $name, $arguments ) {
		if ( preg_match( '/_required$/', $name ) ) {
			if ( $arguments[0] === null || $arguments[0] === '' ) {
				return 'This field is required';
			}

			return call_user_func_array( 
				__NAMESPACE__.'\Validate::'.str_replace( '_required', '', $name ),
				$arguments
			);
		}
	}


	/**
	 * Extend the options from the user function and the validation function
	 * with core defaults.
	 *
	 *  @internal
	 */
	public static function _extend( $userOpts, $prop, $fnOpts ) {
		$cfg = array(
			'message'  => 'Input not valid',
			'required' => false,
			'empty'    => true,
			'optional' => true
		);

		if ( ! is_array( $userOpts ) ) {
			if ( $prop ) {
				$cfg[ $prop ] = $userOpts;
			}

			// Not an array, but the non-array case has been handled above, so
			// just an empty array
			$userOpts = array();
		}

		// Merge into a single array - first array gets priority if there is a
		// key clash, so user first, then function commands and finally the
		// global options 
		$cfg = $userOpts + $fnOpts + $cfg;

		return $cfg;
	}


	/**
	 * Perform common validation using the configuration parameters
	 *
	 *  @internal
	 */
	public static function _common( $val, $cfg ) {
		// `required` is a shortcut for optional==false && empty==false
		$optional = $cfg['required'] ? false : $cfg['optional'];
		$empty    = $cfg['required'] ? false : $cfg['empty'];

		// Error state tests
		if ( ! $optional && $val === null  ) {
			// Value must be given
			return $cfg['message'];
		}
		else if ( ! $empty && $val === '' ) {
			// Value must not be empty
			return $cfg['message'];
		}

		// Validation passed states
		if ( $optional && $val === null ) {
			return true;
		}
		else if ( $empty && $val === '' ) {
			return true;
		}

		// Have the specific validation function perform its tests
		return null;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Basic validation
	 */

	/**
	 * No validation - all inputs are valid.
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return true
	 */
	public static function none( $val, $data, $opts, $host ) {
		return true;
	}


	/**
	 * Basic validation - this is used to perform the validation provided by the
	 * validation options only. If the validation options pass (e.g. `required`,
	 * `empty` and `optional`) then the validation will pass regardless of the
	 * actual value.
	 *
	 * Note that there are two helper short-cut methods that provide the same
	 * function as this method, but are slightly shorter:
	 *
	 * ```
	 * // Required:
	 * Validate::required()
	 *
	 * // is the same as
	 * Validate::basic( $val, $data, array(
	 *   "required" => true
	 * );
	 * ```
	 *
	 * ```
	 * // Optional, but not empty if given:
	 * Validate::notEmpty()
	 *
	 * // is the same as
	 * Validate::basic( $val, $data, array(
	 *   "empty" => false
	 * );
	 * ```
	 * 
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function basic( $val, $data, $opts, $host ) {
		// Common validation with user override option
		$cfg = Validate::_extend( $opts, null, array() );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return true;
	}


	/**
	 * Required field - there must be a value and it must be a non-empty value
	 *
	 * This is a helper short-cut method which is the same as:
	 * 
	 * ```
	 * Validate::basic( $val, $data, array(
	 *   "required" => true
	 * );
	 * ```
	 * 
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function required( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message'  => "This field is required",
			'required' => true
		) );

		$common = Validate::_common( $val, $cfg );
		return $common !== null ?
			$common :
			true;
	}


	/**
	 * Optional field, but if given there must be a non-empty value
	 *
	 * This is a helper short-cut method which is the same as:
	 * 
	 * ```
	 * Validate::basic( $val, $data, array(
	 *   "empty" => false
	 * );
	 * ```
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	static function notEmpty( $val, $data, $opts, $host ) {
		// Supplying this field is optional, but if given, then it must be
		// non-empty (user can override by passing in `empty=true` in opts
		// at which point there is basically no validation
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "This field is required",
			'empty'   => false
		) );

		$common = Validate::_common( $val, $cfg );
		return $common !== null ?
			$common :
			true;
	}


	/**
	 * Validate an input as a boolean value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function boolean( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter true or false"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		if ( filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false ) {
			return $cfg['message'];
		}
		return true;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Number validation methods
	 */

	/**
	 * Check that any input is numeric.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function numeric ( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "This input must be given as a number"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return ! is_numeric( $val ) ?
			$cfg['message'] :
			true;
	}

	/**
	 * Check for a numeric input and that it is greater than a given value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `min` is available for this method to indicate the minimum value. If
	 *    only the default validation options are required, this parameter can
	 *    be given as an integer value, which will be used as the minimum value.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minNum ( $val, $data, $opts, $host ) {
		// `numeric` will do the common validation for us
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$min = is_array($opts) ? $opts['min'] : $opts;
		$cfg = Validate::_extend( $opts, 'min', array(
			'message' => "Number is too small, must be ".$min." or larger"
		) );

		return $val < $min ?
			$cfg['message'] :
			true;
	}

	/**
	 * Check for a numeric input and that it is less than a given value.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `max` is available for this method to indicate the maximum value. If
	 *    only the default validation options are required, this parameter can
	 *    be given as an integer value, which will be used as the maximum value.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function maxNum ( $val, $data, $opts, $host ) {
		// `numeric` will do the common validation for us
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$max = is_array($opts) ? $opts['max'] : $opts;
		$cfg = Validate::_extend( $opts, 'min', array(
			'message' => "Number is too large, must be ".$max." or smaller"
		) );

		return $val > $max ?
			$cfg['message'] :
			true;
	}


	/**
	 * Check for a numeric input and that it is both greater and smaller than
	 * given numbers.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `min` and `max` are available for this method to indicate the minimum
	 *    and maximum values, respectively.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minMaxNum ( $val, $data, $opts, $host ) {
		$numeric = Validate::numeric( $val, $data, $opts, $host );
		if ( $numeric !== true ) {
			return $numeric;
		}

		$min = Validate::minNum( $val, $data, $opts, $host );
		if ( $min !== true ) {
			return $min;
		}

		return Validate::maxNum( $val, $data, $opts, $host );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * String validation methods
	 */

	/**
	 * Validate an input as an e-mail address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function email( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid e-mail address"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_EMAIL) !== false ?
			true :
			$cfg['message'];
	}


	/**
	 * Validate a string has a minimum length.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `min` is available for this method to indicate the minimum string
	 *    length. If only the default validation options are required, this
	 *    parameter can be given as an integer value, which will be used as the
	 *    minimum string length.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minLen( $val, $data, $opts, $host ) {
		$min = is_array($opts) ? $opts['min'] : $opts;
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "The input is too short. ".$min." characters required (".($min-strlen($val))." more required)"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return strlen( $val ) < $min ?
			$cfg['message'] :
			true;
	}


	/**
	 * Validate a string does not exceed a maximum length.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional option of
	 *    `max` is available for this method to indicate the maximum string
	 *    length. If only the default validation options are required, this
	 *    parameter can be given as an integer value, which will be used as the
	 *    maximum string length.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function maxLen( $val, $data, $opts, $host ) {
		$max = is_array($opts) ? $opts['max'] : $opts;
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "The input is ".(strlen($val)-$max)." characters too long"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return strlen( $val ) > $max ?
			$cfg['message'] :
			true;
	}

	/**
	 * Require a string with a certain minimum or maximum number of characters.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `min` and `max` are available for this method to indicate the minimum
	 *    and maximum string lengths, respectively.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function minMaxLen( $val, $data, $opts, $host ) {
		$min = Validate::minLen( $val, $data, $opts, $host );
		if ( $min !== true ) {
			return $min;
		}

		return Validate::maxLen( $val, $data, $opts, $host );
	}


	/**
	 * Validate as an IP address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function ip( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid IP address"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_IP) === false ?
			$cfg['message'] :
			true;
	}


	/**
	 * Validate as an URL address.
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array $opts Validation options. No additional options are
	 *    available or required for this validation method.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function url( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => "Please enter a valid URL"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		return filter_var($val, FILTER_VALIDATE_URL) === false ?
			$cfg['message'] :
			true;
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Date validation methods
	 */

	/**
	 * Check that a valid date input is given
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param array|string $opts If given as a string, then $opts is the date
	 *    format to check the validity of. If given as an array, then the
	 *    date format is in the 'format' parameter, and the return error
	 *    message in the 'message' parameter.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function dateFormat( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, 'format', array(
			'message' => "Date is not in the expected format"
		) );

		$common = Validate::_common( $val, $cfg );
		if ( $common !== null ) {
			return $common;
		}

		$date = \DateTime::createFromFormat( $cfg['format'], $val) ;

		return $date && $date->format( $cfg['format'] ) == $val ?
			true :
			$cfg['message'];
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Database validation methods
	 */

	/**
	 * Check that the given value is unique in the database
	 *
	 *  @param string $val The value to check for validity
	 *  @param string[] $data The full data set submitted
	 *  @param int|array $opts Validation options. The additional options of
	 *    `db` - database connection object, `table` - database table to use and
	 *    `column` - the column to check this value against as value, are also
	 *    available. These options are not required and if not given are
	 *    automatically derived from the Editor and Field instances.
	 *  @return string|true true if the value is valid, a string with an error
	 *    message otherwise.
	 */
	public static function unique( $val, $data, $opts, $host ) {
		$cfg = Validate::_extend( $opts, null, array(
			'message' => 'This field must have a unique value',
			'db'      => null,
			'table'   => null,
			'field'   => null
		) );

		$editor = $host['editor'];
		$field = $host['field'];

		$db = $cfg['db'] ?
			$cfg['db'] :
			$host['db'];

		$table = $cfg['table'] ?
			$cfg['table'] :
			$editor->table(); // Returns an array, but `select` will take an array

		$column = $cfg['field'] ?
			$cfg['field'] :
			$field->dbField();

		$query = $db
			->query( 'select', $table )
			->get( $column )
			->where( $column, $val );

		// If doing an edit, then we need to also discount the current row,
		// since it is of course already validly unique
		if ( $host['action'] === 'edit' ) {
			$query->where( $editor->pkey(), $host['id'], '!=' ); 
		}

		$res = $query->exec();

		return $res->count() === 0 ?
			true :
			$cfg['message']; 
	}
}


class Join extends DataTables\Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Join instance constructor.
	 *  @param string $table Table name to get the joined data from.
	 *  @param string $type Work with a single result ('object') or an array of 
	 *    results ('array') for the join.
	 */
	function __construct( $table=null, $type='object' )
	{
		$this->table( $table );
		$this->type( $type );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */

	/** @var DataTables\Editor\Field[] */
	private $_fields = array();

	/** @var array */
	private $_join = array(
		"parent" => null,
		"child" => null,
		"table" => null
	);

	/** @var string */
	private $_table = null;

	/** @var string */
	private $_type = null;

	/** @var string */
	private $_name = null;

	/** @var boolean */
	private $_get = true;

	/** @var boolean */
	private $_set = true;

	/** @var string */
	private $_aliasParentTable = null;

	/** @var array */
	private $_where = array();

	/** @var boolean */
	private $_whereSet = false;


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */
	
	/**
	 * Get / set parent table alias.
	 * 
	 * When working with a self referencing table (i.e. a column in the table contains
	 * a primary key value from its own table) it can be useful to set an alias on the
	 * parent table's name, allowing a self referencing Join. For example:
	 *   <code>
	 *   SELECT p2.publisher 
	 *   FROM   publisher as p2
	 *   JOIN   publisher on (publisher.idPublisher = p2.idPublisher)
	 *   <code>
	 * Where, in this case, `publisher` is the table that is used by the Editor instance,
	 * and you want to use `Join` to link back to the table (resolving a name for example).
	 * This method allows that alias to be set. Fields can then use standard SQL notation
	 * to select a field, for example `p2.publisher` or `publisher.publisher`.
	 *  @param string $_ Table alias to use
	 *  @return string|self Table alias set (which is null by default), or self if used as
	 *    a setter.
	 */
	public function aliasParentTable ( $_=null )
	{
		return $this->_getSet( $this->_aliasParentTable, $_ );
	}


	/**
	 * Get / set field instances.
	 * 
	 * The list of fields designates which columns in the table that will be read
	 * from the joined table.
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function field ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set field instances.
	 * 
	 * An alias of {@link field}, for convenience.
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function fields ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set get attribute.
	 * 
	 * When set to false no read operations will occur on the join tables.
	 *  @param boolean $_ Value
	 *  @return boolean|self Name
	 */
	public function get ( $_=null )
	{
		return $this->_getSet( $this->_get, $_ );
	}


	/**
	 * Get / set join properties.
	 *
	 * Define how the SQL will be performed, on what columns. There are basically
	 * two types of join that are supported by Editor here, a direct foreign key
	 * reference in the join table to the parent table's primary key, or a link 
	 * table that contains just primary keys for the parent and child tables (this
	 * approach is usually used with a {@link type} of 'array' since you can often
	 * have multiple links between the two tables, while a direct foreign key
	 * reference will typically use a type of 'object' (i.e. a single entry).
	 *  @param string|string[] $parent Parent table's primary key names. If
	 *    used with a link table (i.e. third parameter to this method is given, then
	 *    an array should be used, with the first element being the pkey's name in
	 *    the parent table, and the second element being the key's name in the link
	 *    table.
	 *  @param string|string[] $child Child table's primary key names. If
	 *    used with a link table (i.e. third parameter to this method is given, then
	 *    an array should be used, with the first element being the pkey's name in
	 *    the child table, and the second element being the key's name in the link
	 *    table.
	 *  @param {string} $table Join table name, if using a link table
	 *
	 *  @example
	 *    // Using a link table
	 *    Join::inst( 'access', 'array' )
	 *      ->join(
	 *        array( 'id', 'user_id' ),
	 *        array( 'id', 'access_id' ),
	 *        'user_access'
	 *      )
	 *
	 *  @example
	 *    // Using a direct reference (no link table)
	 *    Join::inst( 'extra', 'object' )
	 *      ->join( 'id', 'user_id' )
	 */
	public function join ( $parent=null, $child=null, $table=null )
	{
		if ( $parent === null && $child === null ) {
			return $this->_join();
		}

		$this->_join['parent'] = $parent;
		$this->_join['child'] = $child;
		$this->_join['table'] = $table;
		return $this;
	}


	/**
	 * Get / set name.
	 * 
	 * The `name` of the Join is the JSON property key that is used when 
	 * 'getting' the data, and the HTTP property key (in a JSON style) when
	 * 'setting' data. Typically the name of the db table will be used here,
	 * but this method allows that to be overridden.
	 *  @param string $_ Field name
	 *  @return String|self Name
	 */
	public function name ( $_=null )
	{
		return $this->_getSet( $this->_name, $_ );
	}


	/**
	 * Get / set set attribute.
	 * 
	 * When set to false no write operations will occur on the join tables.
	 * This can be useful when you want to display information which is joined,
	 * but want to only perform write operations on the parent table.
	 *  @param boolean $_ Value
	 *  @return boolean|self Name
	 */
	public function set ( $_=null )
	{
		return $this->_getSet( $this->_set, $_ );
	}


	/**
	 * Get / set join table name.
	 *
	 * Please note that this will also set the {@link name} used by the Join
	 * as well. This is for convenience as the JSON output / HTTP input will
	 * typically use the same name as the database name. If you want to set a
	 * custom name, the {@link name} method must be called ***after*** this one.
	 *  @param string $_ Name of the table to read the join data from
	 *  @return String|self Name of the join table, or self if used as a setter.
	 */
	public function table ( $_=null )
	{
		if ( $_ !== null ) {
			$this->_name = $_;
		}
		return $this->_getSet( $this->_table, $_ );
	}


	/**
	 * Get / set the join type.
	 * 
	 * The join type allows the data that is returned from the join to be given
	 * as an array (i.e. working with multiple possibly results for each record from
	 * the parent table), or as an object (i.e. working which one and only one result
	 * for each record form the parent table).
	 *  @param string $_ Join type ('object') or an array of 
	 *    results ('array') for the join.
	 *  @return String|self Join type, or self if used as a setter.
	 */
	public function type ( $_=null )
	{
		return $this->_getSet( $this->_type, $_ );
	}


	/**
	 * Where condition to add to the query used to get data from the database.
	 * Note that this is applied to the child table.

	 * 
	 * Can be used in two different ways, as where( field, value ) or as an
	 * array of conditions to use: where( array('fieldName', ...),
	 * array('value', ...) );
	 *
	 *  @param string|string[] $key   Single field name, or an array of field names.
	 *  @param string|string[] $value Single field value, or an array of values.
	 *  @param string          $op    Condition operator: <, >, = etc
	 *  @return string[]|self Where condition array, or self if used as a setter.
	 */
	public function where ( $key=null, $value=null, $op='=' )
	{
		if ( $key === null ) {
			return $this->_where;
		}

		$this->_where[] = array(
			"key"   => $key,
			"value" => $value,
			"op"    => $op
		);

		return $this;
	}


	/**
	 * Get / set if the WHERE conditions should be included in the create and
	 * edit actions.
	 * 
	 * This means that the fields which have been used as part of the 'get'
	 * WHERE condition (using the `where()` method) will be set as the values
	 * given.
	 *
	 * This is default false (i.e. they are not included).
	 *
	 *  @param boolean $_ Include (`true`), or not (`false`)
	 *  @return boolean Current value
	 */
	public function whereSet ( $_=null )
	{
		return $this->_getSet( $this->_whereSet, $_ );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Get data
	 *  @param Database $db Database reference to use
	 *  @param array $dteTable Host table from the Editor class, only the first is used
	 *  @param string $pkey Host table primary key
	 *  @param string $idPrefix DOM id prefix
	 *  @param string[] $data Data from the parent table's get and were we need
	 *    to add out output.
	 *  @internal
	 */
	public function data( $db, $dteTable, $pkey, $idPrefix, &$data )
	{
		if ( ! $this->_get ) {
			return;
		}

		$dteTable = $dteTable[0];
		$dteTableAlias = $this->_aliasParentTable === null ? $dteTable : $this->_aliasParentTable;

		$joinField = isset($this->_join['table']) ? $this->_join['parent'][0] : $this->_join['parent'];
		$pkeyIsJoin = $pkey === $joinField || $pkey === $dteTable.'.'.$joinField;

		// When doing a self join we need to use the parent table's name for the primary key. Otherwise
		// we want the aliased parent table's name!
		$pkeyTable = $this->_table===$dteTable ? $dteTable : $dteTableAlias;

		// Sanity check that table selector fields are read only, and have an name without
		// a dot (for DataTables mData to be able to read it)
		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( strpos( $field->dbField() , "." ) !== false ) {
				if ( $field->set() && $this->_set ) {
					echo json_encode( array(
						"sError" => "Table selected fields (i.e. '{table}.{column}') in `Join` ".
							"must be read only. Use `set(false)` for the field to disable writing."
					) );
					exit(0);
				}

				if ( strpos( $field->name() , "." ) !== false ) {
					echo json_encode( array(
						"sError" => "Table selected fields (i.e. '{table}.{column}') in `Join` ".
							"must have a name alias which does not contain a period ('.'). Use ".
							"name('---') to set a name for the field"
					) );
					exit(0);
				}
			}
		}

		// Set up the JOIN query
		$stmt = $db
			->query( 'select' )
			->get( $pkeyTable.'.'.$joinField.' as _dte_pkey' )
			->get( $this->_fields('get') )
			->table( $dteTable .' as '. $dteTableAlias );

		for ( $i=0 ; $i<count($this->_where) ; $i++ ) {
			$stmt->where(
				$this->_where[$i]['key'],
				$this->_where[$i]['value'],
				$this->_where[$i]['op']
			);
		}

		if ( isset($this->_join['table']) ) {
			// Working with a link table
			$stmt
				->join(
					$this->_join['table'],
					$dteTableAlias.'.'.$this->_join['parent'][0] .' = '. $this->_join['table'].'.'.$this->_join['parent'][1]
				)
				->join(
					$this->_table,
					$this->_table.'.'.$this->_join['child'][0] .' = '. $this->_join['table'].'.'.$this->_join['child'][1]
				);
		}
		else {
			// No link table in the middle
			$stmt
				->join(
					$this->_table,
					$this->_table.'.'.$this->_join['child'] .' = '. $dteTableAlias.'.'.$this->_join['parent']
				);
		}
		
		$res = $stmt->exec();
		if ( ! $res ) {
			return;
		}

		// Map to primary key for fast lookup
		$join = array();
		while ( $row=$res->fetch() ) {
			$inner = array();

			for ( $j=0 ; $j<count($this->_fields) ; $j++ ) {
				$field = $this->_fields[$j];
				if ( $field->apply('get') ) {
					$inner[ $field->name() ] = $field->val('get', $row);
				}
			}

			if ( $this->_type === 'object' ) {
				$join[ $row['_dte_pkey'] ] = $inner;
			}
			else {
				if ( !isset( $join[ $row['_dte_pkey'] ] ) ) {
					$join[ $row['_dte_pkey'] ] = array();
				}
				$join[ $row['_dte_pkey'] ][] = $inner;
			}
		}

		// Check that the joining field is available
		// The joining key can come from the Editor instance's primary key, or
		// any other field. If the instance's pkey, then we've got that in the DT_RowId
		// parameter, so we can use that. Otherwise, the key must be in the field list.
		if ( !$pkeyIsJoin && count($data) > 0 && !isset($data[0][ $joinField ]) ) {
			echo json_encode( array(
				"sError" => "Join was performed on the field '{$joinField}' which was not "
					."included in the Editor field list. The join field must be included "
					."as a regular field in the Editor instance."
			) );
			exit(0);
		}

		// Loop over the data and do a join based on the data available
		for ( $i=0 ; $i<count($data) ; $i++ ) {
			$rowPKey = $pkeyIsJoin ? 
				str_replace( $idPrefix, '', $data[$i]['DT_RowId'] ) :
				$data[$i][ $joinField ];

			if ( isset( $join[$rowPKey] ) ) {
				$data[$i][ $this->_name ] = $join[$rowPKey];
			}
			else {
				$data[$i][ $this->_name ] = ($this->_type === 'object') ?
					(object)array() : array();
			}
		}
	}


	/**
	 * Create a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @internal
	 */
	public function create ( $db, $parentId, $data )
	{
		if ( ! $this->_set || ! isset($data[$this->_name]) ) {
			return;
		}
		
		if ( $this->_type === 'object' ) {
			$this->_insert( $db, $parentId, $data[$this->_name] );
		}
		else {
			for ( $i=0 ; $i<count($data[$this->_name]) ; $i++ ) {
				$this->_insert( $db, $parentId, $data[$this->_name][$i] );
			}
		}
	}


	/**
	 * Update a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @internal
	 */
	public function update ( $db, $parentId, $data )
	{
		if ( ! $this->_set ) {
			return;
		}
		
		if ( $this->_type === 'object' ) {
			// update or insert
			$this->_update_row( $db, $parentId, $data[$this->_name] );
		}
		else {
			// WARNING - this will remove rows and then readd them. Any
			// data not in the field list WILL BE LOST
			// todo - is there a better way of doing this?
			$this->remove( $db, array($parentId) );
			$this->create( $db, $parentId, $data );
		}
	}


	/**
	 * Delete rows
	 *  @param Database $db Database reference to use
	 *  @param int[] $ids Parent row IDs to delete
	 *  @internal
	 */
	public function remove ( $db, $ids )
	{
		if ( ! $this->_set ) {
			return;
		}
		
		if ( isset($this->_join['table']) ) {
			$stmt = $db
				->query( 'delete' )
				->table( $this->_join['table'] )
				->or_where( $this->_join['parent'][1], $ids )
				->exec();
		}
		else {
			$stmt = $db
				->query( 'delete' )
				->table( $this->_table )
				->where_group( true )
				->or_where( $this->_join['child'], $ids )
				->where_group( false );

			for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
				$stmt->where( $this->_where[$i]['key'], $this->_where[$i]['value'] );
			}

			$stmt->exec();
		}
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Create a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @private
	 */
	private function _insert( $db, $parentId, $data )
	{
		if ( isset($this->_join['table']) ) {
			// Insert keys into the join table
			$stmt = $db
				->query('insert')
				->table( $this->_join['table'] )
				->set( $this->_join['parent'][1], $parentId )
				->set( $this->_join['child'][1], $data[$this->_join['child'][0]] )
				->exec();
		}
		else {
			// Insert values into the target table
			$stmt = $db
				->query('insert')
				->table( $this->_table )
				->set( $this->_join['child'], $parentId );

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply( 'set', $data ) ) {
					$stmt->set( $field->dbField(), $field->val('set', $data) );
				}
			}

			// If the where condition variables should also be added to the database
			if ( $this->_whereSet ) {
				for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
					$stmt->set( $this->_where[$i]['key'], $this->_where[$i]['value'] );
				}
			}

			$stmt->exec(); 
		}
	}


	/**
	 * Update a row.
	 *  @param Database $db Database reference to use
	 *  @param int $parentId Parent row's primary key value
	 *  @param string[] $data Data to be set for the join
	 *  @private
	 */
	private function _update_row ( $db, $parentId, $data )
	{
		if ( isset($this->_join['table']) ) {
			// Got a link table, just insert the pkey references
			$db->push(
				$this->_join['table'],
				array(
					$this->_join['parent'][1] => $parentId,
					$this->_join['child'][1]  => $data[$this->_join['child'][0]]
				),
				array(
					$this->_join['parent'][1] => $parentId
				)
			);
		}
		else {
			// No link table, just a direct reference
			$set = array(
				$this->_join['child'] => $parentId
			);

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply( 'set', $data ) ) {
					$set[ $field->dbField() ] = $field->val('set', $data);
				}
			}

			// Add WHERE conditions
			$where = array($this->_join['child'] => $parentId);
			for ( $i=0, $ien=count($this->_where) ; $i<$ien ; $i++ ) {
				$where[ $this->_where[$i]['key'] ] = $this->_where[$i]['value'];

				// Is there any point in this? Is there any harm?
				if ( $this->_whereSet ) {
					$set[ $this->_where[$i]['key'] ] = $this->_where[$i]['value'];
				}
			}

			$db->push( $this->_table, $set, $where );
		}
	}


	/**
	 * Create an SQL string from the fields that this instance knows about for
	 * using in queries
	 *  @param string $direction Direction: 'get' or 'set'.
	 *  @private
	 */
	private function _fields ( $direction )
	{
		$fields = array();

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( $field->apply( $direction, null ) ) {
				if ( strpos( $field->dbField() , "." ) === false ) {
					$fields[] = $this->_table.'.'.$field->dbField() ." as ".$field->dbField();;
				}
				else {
					$fields[] = $field->dbField();// ." as ".$field->dbField();
				}
			}
		}

		return $fields;
	}
}


class Format {
	/** Date format: 2012-03-09. jQuery UI equivalent format: yy-mm-dd */
	const DATE_ISO_8601 = "Y-m-d";

	/** Date format: Fri, 9 Mar 12. jQuery UI equivalent format: D, d M y */
	const DATE_ISO_822 = "D, j M y";
	
	/** Date format: Friday, 09-Mar-12.  jQuery UI equivalent format: DD, dd-M-y */
	const DATE_ISO_850 = "l, d-M-y";
	
	/** Date format: Fri, 9 Mar 12. jQuery UI equivalent format: D, d M y */
	const DATE_ISO_1036 = "D, j M y";
	
	/** Date format: Fri, 9 Mar 2012. jQuery UI equivalent format: D, d M yy */
	const DATE_ISO_1123 = "D, j M Y";
	
	/** Date format: Fri, 9 Mar 2012. jQuery UI equivalent format: D, d M yy */
	const DATE_ISO_2822 = "D, j M Y";
	
	/** Date format: 1331251200. jQuery UI equivalent format: @ */
	const DATE_TIMESTAMP = "U";
	
	/** Date format: 1331251200. jQuery UI equivalent format: @ */
	const DATE_EPOCH = "U";


	/**
	 * Convert from SQL date / date time format to a format given by the options
	 * parameter.
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert from MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Format to convert to using PHP date() options.
	 *   @return string Formatted date or empty string on error.
	 */
	public static function date_sql_to_format( $val, $data, $opts ) {
		$date = new \DateTime( $val );

		// Allow empty strings or invalid dates
		if ( $val && $date ) {
			return date_format( $date, $opts );
		}
		return null;
	}


	/**
	 * Convert from from a format given by the options parameter to a format
	 * that SQL servers will recognise as a date.
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert to MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Format to convert from using PHP date() options.
	 *   @return string Formatted date or null on error.
	 */
	public static function date_format_to_sql( $val, $data, $opts ) {
		// Note that this assumes the date is in the correct format (should be
		// checked by validation before being used here!)
		$date = date_create_from_format($opts, $val);

		// Invalid dates or empty string are replaced with null. Use the
		// validation to ensure the date given is valid if you don't want this!
		if ( $val && $date ) {
			return date_format( $date, 'Y-m-d' );
		}
		return null;
	}


	/**
	 * Convert from one date time format to another
	 *
	 * Typical use of this method is to use it with the 
	 * {@link Field::getFormatter} and {@link Field::setFormatter} methods of
	 * {@link Field} where the parameters required for this method will be 
	 * automatically satisfied.
	 *   @param string $val Value to convert from MySQL date format
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Array with `from` and `to` properties which are the
	 *     formats to convert from and to
	 *   @return string Formatted date or empty string on error.
	 */
	public static function datetime( $val, $data, $opts ) {
		$date = date_create_from_format($opts['from'], $val);

		// Allow empty strings or invalid dates
		if ( $date ) {
			return date_format( $date, $opts['to'] );
		}
		return '';
	}


	/**
	 * Convert an array of values from a checkbox into a string which can be
	 * used to store in a text field in a database.
	 *   @param string $val Value to convert to from an array to a string
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function implode( $val, $data, $opts ) {
		if ( $opts === null ) {
			$opts = '|';
		}
		return implode($opts, $val);
	}


	/**
	 * Convert a string of values into an array for use with checkboxes.
	 *   @param string $val Value to convert to from a string to an array
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function explode( $val, $data, $opts ) {
		if ( $opts === null ) {
			$opts = '|';
		}
		return explode($opts, $val);
	}


	/**
	 * Convert an empty string to `null`. Null values are very useful in
	 * databases, but HTTP variables have no way of representing `null` as a
	 * value, often leading to an empty string and null overlapping. This method
	 * will check the value to operate on and return null if it is empty.
	 *   @param string $val Value to convert to from a string to an array
	 *   @param string[] $data Data for the whole row / submitted data
	 *   @param string $opts Field delimiter
	 *   @return string Formatted date or null on error.
	 */
	public static function nullEmpty ( $val, $data, $opts ) {
		if ( $val === '' ) {
			return null;
		}
		return $val;
	}
}


class Field extends DataTables\Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Field instance constructor.
	 *  @param string $dbField Name of the database column
	 *  @param string $name Name to use in the JSON output from Editor and the
	 *    HTTP submit from the client-side when editing. If not given then the
	 *    $dbField name is used.
	 */
	function __construct( $dbField=null, $name=null )
	{
		if ( $dbField !== null && $name === null ) {
			// Allow just a single parameter to be passed - each can be 
			// overridden if needed later using the API.
			$this->name( $dbField );
			$this->dbField( $dbField );
		}
		else {
			$this->name( $name );
			$this->dbField( $dbField );
		}
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private parameters
	 */

	/** @var string */
	private $_dbField = null;

	/** @var boolean */
	private $_get = true;

	/** @var mixed */
	private $_getFormatter = null;

	/** @var mixed */
	private $_getFormatterOpts = null;

	/** @var string */
	private $_name = null;

	/** @var boolean */
	private $_set = true;

	/** @var mixed */
	private $_setFormatter = null;

	/** @var mixed */
	private $_setFormatterOpts = null;

	/** @var mixed */
	private $_validator = null;

	/** @var mixed */
	private $_validatorOpts = null;



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */


	/**
	 * Get / set the DB field name.
	 * 
	 * Note that when used as a setter, an alias can be given for the field
	 * using the SQL `as` keyword - for example: `firstName as name`. In this
	 * situation the dbField is set to the field name before the `as`, and the
	 * field's name (`name()`) is set to the name after the ` as `.
	 *
	 * As a result of this, the following constructs have identical
	 * functionality:
	 *
	 *    Field::inst( 'firstName as name' );
	 *    Field::inst( 'firstName', 'name' );
	 *
	 *  @param string $_ Value to set if using as a setter.
	 *  @return string|self The name of the db field if no parameter is given,
	 *    or self if used as a setter.
	 */
	public function dbField ( $_=null )
	{
		if ( $_ === null ) {
			return $this->_dbField;
		}

		if ( strpos( $_, ' as ' ) ) {
			$a = explode( ' as ', $_ );
			$this->_dbField = trim( $a[0] );
			$this->_name = trim( $a[1] );
		}
		else {
			$this->_dbField = $_;
		}

		return $this;
	}


	/**
	 * Get / set the 'get' property of the field.
	 *
	 * A field can be marked as write only when setting the get property to false
	 * here.
	 *  @param boolean $_ Value to set if using as a setter.
	 *  @return boolean|self The get property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function get ( $_=null )
	{
		return $this->_getSet( $this->_get, $_ );
	}


	/**
	 * Get formatter for the field's data.
	 *
	 * When the data has been retrieved from the server, it can be passed through
	 * a formatter here, which will manipulate (format) the data as required. This
	 * can be useful when, for example, working with dates and a particular format
	 * is required on the client-side.
	 *
	 * Editor has a number of formatters available with the {@link Format} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as a setter. Can be given as
	 *    a closure function or a string with a reference to a function that will
	 *    be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the get formatting
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the formatter used.
	 *  @return function|string|self The get formatter if no parameter is given, or 
	 *    self if used as a setter.
	 */
	public function getFormatter ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_getFormatterOpts = $opts;
		}
		return $this->_getSet( $this->_getFormatter, $_ );
	}


	/**
	 * Get / set the 'name' property of the field.
	 *
	 * The name is typically the same as the dbField name, since it makes things
	 * less confusing(!), but it is possible to set a different name for the data
	 * which is used in the JSON returned to DataTables in a 'get' operation and
	 * the field name used in a 'set' operation.
	 *  @param string $_ Value to set if using as a setter.
	 *  @return string|self The name property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function name ( $_=null )
	{
		return $this->_getSet( $this->_name, $_ );
	}


	/**
	 * Get / set the 'set' property of the field.
	 *
	 * A field can be marked as read only when setting the get property to false
	 * here.
	 *  @param boolean $_ Value to set if using as a setter.
	 *  @return boolean|self The set property if no parameter is given, or self
	 *    if used as a setter.
	 */
	public function set ( $_=null )
	{
		return $this->_getSet( $this->_set, $_ );
	}


	/**
	 * Set formatter for the field's data.
	 *
	 * When the data has been retrieved from the server, it can be passed through
	 * a formatter here, which will manipulate (format) the data as required. This
	 * can be useful when, for example, working with dates and a particular format
	 * is required on the client-side.
	 * Editor has a number of formatters available with the {@link Format} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as a setter. Can be given as
	 *    a closure function or a string with a reference to a function that will
	 *    be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the get formatting
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the formatter used.
	 *  @return function|string|self The set formatter if no parameter is given, or 
	 *    self if used as a setter.
	 */
	public function setFormatter ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_setFormatterOpts = $opts;
		}
		return $this->_getSet( $this->_setFormatter, $_ );
	}


	/**
	 * Get / set the 'validator' of the field.
	 *
	 * The validator can be used to check if any abstract piece of data is valid
	 * or not according to the given rules of the validation function used.
	 * Editor has a number of validation available with the {@link Validate} class
	 * which can be used directly with this method.
	 *  @param function|string $_ Value to set if using as the validation method. 
	 *    Can be given as a closure function or a string with a reference to a 
	 *    function that will be called with call_user_func().
	 *  @param mixed $opts Variable that is passed through to the validation
	 *    function - can be useful for passing through extra information such as
	 *    date formatting string, or a required flag. The actual options available
	 *    depend upon the validation function used.
	 *  @return function|string|self The validation method if no parameter is given, 
	 *    or self if used as a setter.
	 */
	public function validator ( $_=null, $opts=null )
	{
		if ( $opts !== null ) {
			$this->_validatorOpts = $opts;
		}
		return $this->_getSet( $this->_validator, $_ );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	/**
	 * Check to see if a field should be used for a particular action (get or set).
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param string $direction Direction that the data is travelling  - 'get' is
	 *    reading data, and 'set' is writing it to the DB.
	 *  @param array $data Data submitted from the client-side when setting.
	 *  @return boolean true if the field should be used in the get / set.
	 *  @internal
	 */
	public function apply ( $direction, $data=null )
	{
		if ( $direction === 'get' ) {
			// Get action - can we get this field
			return $this->_get;
		}
		else {
			// Note that validation must be done on input data before we get here
			// Set action - can we set this field
			if ( ! $this->_set ) {
				return false;
			}

			// Check it it was in the submitted data. It not, then not required
			// (validation would have failed if it was) and therefore we don't
			// set it. Check for a set formatter as well, as it can format data
			// from some other source
			if ( ! $this->_setFormatter && ! $this->_inData( $this->name(), $data ) ) {
				return false;
			}

			// In the data set, so use it
			return true;
		}
	}


	/**
	 * Get the value of the field, taking into account if it is coming from the
	 * DB or from a POST. If formatting has been specified for this field, it
	 * will be applied here.
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param string $direction Direction that the data is travelling  - 'get' is
	 *    reading data, and 'set' is writing it to the DB.
	 *  @param array $data Data submitted from the client-side when setting or the
	 *    data for the row when getting data from the DB.
	 *  @return string Value for the field
	 *  @internal
	 */
	public function val ( $direction, $data )
	{
		if ( $direction === 'get' ) {
			// Use data from the database, so the db name
			$namedData = isset( $data[ $this->_dbField ] ) ?
				$data[ $this->_dbField ] :
				null;

			// Three cases for the getFormatter - closure, string or null
			if ( $this->_getFormatter ) {
				if ( is_string( $this->_getFormatter ) ) {
					// Don't require the Editor namespace if DataTables validator is given as a string
					if ( strpos($this->_getFormatter, "Format::") === 0 ) {
						// Editor formatter
						return call_user_func(
							"\\DataTables\\Editor\\".$this->_getFormatter,
							$namedData,
							$data,
							$this->_getFormatterOpts
						);
					}

					// User function (string identifier)
					return call_user_func(
						$this->_getFormatter,
						$namedData,
						$data,
						$this->_getFormatterOpts
					);
				}

				// Closure
				$getFormatter = $this->_getFormatter;
				return $getFormatter(
					$namedData,
					$data,
					$this->_getFormatterOpts
				);
			}
			return $namedData;
		}
		else {
			// Use data for settings from the POST / GET data, so use the name
			$namedData = $this->_readProp( $this->name(), $data );

			// Three cases for the setFormatter - closure, string or null
			if ( $this->_setFormatter ) {
				if ( is_string( $this->_setFormatter ) ) {
					// Don't require the Editor namespace if DataTables validator is given as a string
					if ( strpos($this->_setFormatter, "Format::") === 0 ) {
						// Editor formatter
						return call_user_func(
							"\\DataTables\\Editor\\".$this->_setFormatter,
							$namedData,
							$data,
							$this->_setFormatterOpts
						);
					}

					// User function (string identifier)
					return call_user_func(
						$this->_setFormatter,
						$namedData,
						$data,
						$this->_setFormatterOpts
					);
				}

				// Closure
				$setFormatter = $this->_setFormatter;
				return $setFormatter(
					$namedData,
					$data,
					$this->_setFormatterOpts
				);
			}
			return $namedData;
		}
	}

	public function write( &$out, $data )
	{
		$this->_writeProp( $out, $this->name(), $this->val('get', $data) );
	}



	/**
	 * Check the validity of the field based on the data submitted. Note that
	 * this validation is performed on the wire data - i.e. that which is
	 * submitted, before any setFormatter is run
	 *
	 * Called by the Editor / Join class instances - not expected for general
	 * consumption - internal.
	 *  @param array $data Data submitted from the client-side 
	 *  @param Editor $editor Editor instance
	 *  @return boolean Indicate if a field is valid or not.
	 *  @internal
	 */
	public function validate ( $data, $editor )
	{
		// Three cases for the validator - closure, string or null
		if ( ! $this->_validator ) {
			return true;
		}

		$val = $this->_readProp( $this->name(), $data );

		if ( is_string( $this->_validator ) ) {
			$processData = $editor->inData();
			$instances = array(
				'action' => $processData['action'],
				'id'     => isset($processData['id']) ?
					str_replace( $editor->idPrefix(), '', $processData['id'] ) :
					null,
				'field'  => $this,
				'editor' => $editor,
				'db'     => $editor->db()
			);

			// Don't require the Editor namespace if DataTables validator is given as a string
			if ( strpos($this->_validator, "Validate::") === 0 ) {
				return call_user_func( "\\DataTables\\Editor\\".$this->_validator, $val, $data, $this->_validatorOpts, $instances );
			}
			return call_user_func( $this->_validator, $val, $data, $this->_validatorOpts, $instances );
		}
		$validator = $this->_validator;
		return $validator( $val, $data, $this );
	}






	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Write the field's value to an array structure, using Javascript dotted
	 * object notation to indicate JSON data structure. For example `name.first`
	 * gives the data structure: `name: { first: ... }`. This matches DataTables
	 * own ability to do this on the client-side, although this doesn't
	 * implement implement quite such a complex structure (no array / function
	 * support).
	 *
	 * @param  array  &$out   Array to write the data to
	 * @param  string  $name  Javascript dotted object name to write to
	 * @param  *       $value Value to write
	 * @private
	 */
	private function _writeProp( &$out, $name, $value )
	{
		if ( strpos($name, '.') === false ) {
			$out[ $name ] = $value;
			return;
		}

		$orig = $name;
		$names = explode( '.', $name );
		$inner = &$out;
		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			$name = $names[$i];

			if ( ! isset( $inner[ $name ] ) ) {
				$inner[ $name ] = array();
			}
			else if ( ! is_array( $inner[ $name ] ) ) {
				throw new \Exception(
					'A property with the name `'.$name.'` already exists. This '.
					'can occur if you have properties which share a prefix - '.
					'for example `name` and `name.first`.'
				);
			}

			$inner = &$inner[ $name ];
		}

		if ( isset( $inner[ $names[count($names)-1] ] ) ) {
			throw new \Exception(
				'Duplicate field detected - a field with the name `'.$orig.'` '.
				'already exists.'
			);
		}

		$inner[ $names[count($names)-1] ] = $value;
	}


	/**
	 * Read a value from a data structure, using Javascript dotted object
	 * notation. This is the inverse of the `_writeProp` method and provides
	 * the same support, matching DataTables' ability to read nested JSON
	 * data objects.
	 *
	 * @param  string $name  Javascript dotted object name to write to
	 * @param  array  $out   Data source array to read from
	 * @return *             The read value, or null if no value found.
	 * @private
	 */
	private function _readProp ( $name, $data )
	{
		if ( strpos($name, '.') === false ) {
			return isset( $data[ $name ] ) ?
				$data[ $name ] :
				null;
		}

		$names = explode( '.', $name );
		$inner = $data;

		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			if ( ! isset( $inner[ $names[$i] ] ) ) {
				return null;
			}

			$inner = $inner[ $names[$i] ];
		}

		if ( isset( $names[count($names)-1] ) ) {
			$idx = $names[count($names)-1];

			return isset( $inner[ $idx ] ) ?
				$inner[ $idx ] :
				null;
		}
		return null;
	}


	/**
	 * Check is a parameter is in the submitted data set. This is functionally
	 * the same as the `_readProp()` method, but in this case a binary value
	 * is required to indicate if the value is present or not.
	 *
	 * @param  string $name  Javascript dotted object name to write to
	 * @param  array  $out   Data source array to read from
	 * @return boolean       `true` if present, `false` otherwise
	 * @private
	 */
	private function _inData ( $name, $data )
	{
		if ( strpos($name, '.') === false ) {
			return isset( $data[ $name ] ) ?
				true :
				false;
		}

		$names = explode( '.', $name );
		$inner = $data;

		for ( $i=0 ; $i<count($names)-1 ; $i++ ) {
			if ( ! isset( $inner[ $names[$i] ] ) ) {
				return false;
			}

			$inner = $inner[ $names[$i] ];
		}

		return isset( $names[count($names)-1] ) ?
			true :
			false;
	}
}


class Editor extends Ext {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Constructor
	 */

	/**
	 * Constructor.
	 *  @param Database $db An instance of the DataTables Database class that we can
	 *    use for the DB connection. Can be given here or with the 'db' method.
	 *    <code>
	 *      456
	 *    </code>
	 *  @param string|array $table The table name in the database to read and write
	 *    information from and to. Can be given here or with the 'table' method.
	 *  @param string $pkey Primary key column name in the table given in the $table
	 *    parameter. Can be given here or with the 'pkey' method.
	 */
	function __construct( $db=null, $table=null, $pkey=null )
	{
		// Set constructor parameters using the API - note that the get/set will
		// ignore null values if they are used (i.e. not passed in)
		$this->db( $db );
		$this->table( $table );
		$this->pkey( $pkey );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public properties
	 */

	/** @var string */
	public $version = '1.3.3';



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private properties
	 */

	/** @var DataTables\Database */
	private $_db = null;

	/** @var DataTables\Editor\Field[] */
	private $_fields = array();

	/** @var array */
	private $_formData;

	/** @var array */
	private $_processData;

	/** @var string */
	private $_idPrefix = 'row_';

	/** @var DataTables\Editor\Join[] */
	private $_join = array();

	/** @var string */
	private $_pkey = 'id';

	/** @var string[] */
	private $_table = array();

	/** @var array */
	private $_where = array();

	/** @var array */
	private $_leftJoin = array();

	/** @var boolean */
	private $_whereSet = false;

	/** @var array */
	private $_out = array(
		"id" => -1,
		"fieldErrors" => array(),
		"error" => "",
		"data" => array()
	);



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 */

	/**
	 * Get the data constructed in this instance.
	 * 
	 * This will get the PHP array of data that has been constructed for the 
	 * command that has been processed by this instance. Therefore only useful after
	 * process has been called.
	 *  @return array Processed data array.
	 */
	public function data ()
	{
		return $this->_out;
	}


	/**
	 * Get / set the DB connection instance
	 *  @param Database $_ DataTable's Database class instance to use for database
	 *    connectivity. If not given, then used as a getter.
	 *  @return Database|self The Database connection instance if no parameter
	 *    is given, or self if used as a setter.
	 */
	public function db ( $_=null )
	{
		return $this->_getSet( $this->_db, $_ );
	}


	/**
	 * Get / set field instances.
	 * 
	 * The list of fields designates which columns in the table that Editor will work
	 * with (both get and set).
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function field ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set field instances.
	 * 
	 * An alias of {@link field}, for convenience.
	 *  @param Field $_... Instances of the {@link Field} class, given as a single 
	 *    instance of {@link Field}, an array of {@link Field} instances, or multiple
	 *    {@link Field} instance parameters for the function.
	 *  @return Field[]|self Array of fields, or self if used as a setter.
	 *  @see {@link Field} for field documentation.
	 */
	public function fields ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_fields, $_, true );
	}


	/**
	 * Get / set the DOM prefix.
	 *
	 * Typically primary keys are numeric and this is not a valid ID value in an
	 * HTML document - is also increases the likelihood of an ID clash if multiple
	 * tables are used on a single page. As such, a prefix is assigned to the 
	 * primary key value for each row, and this is used as the DOM ID, so Editor
	 * can track individual rows.
	 *  @param string $_ Primary key's name. If not given, then used as a getter.
	 *  @return string|self Primary key value if no parameter is given, or
	 *    self if used as a setter.
	 */
	public function idPrefix ( $_=null )
	{
		return $this->_getSet( $this->_idPrefix, $_ );
	}


	/**
	 * Get the data that is being processed by the Editor instance. This is only
	 * useful once the `process()` method has been called, and is available for
	 * use in validation and formatter methods.
	 *
	 *   @return array Data given to `process()`.
	 */
	public function inData ()
	{
		return $this->_processData;
	}


	/**
	 * Get / set join instances. Note that for the majority of use cases you
	 * will want to use the `leftJoin()` method. It is significantly easier
	 * to use if you are just doing a simple left join!
	 * 
	 * The list of Join instances that Editor will join the parent table to
	 * (i.e. the one that the {@link table} and {@link fields} methods refer to
	 * in this class instance).
	 *
	 *  @param Join $_,... Instances of the {@link Join} class, given as a
	 *    single instance of {@link Join}, an array of {@link Join} instances,
	 *    or multiple {@link Join} instance parameters for the function.
	 *  @return Join[]|self Array of joins, or self if used as a setter.
	 *  @see {@link Join} for joining documentation.
	 */
	public function join ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_join, $_, true );
	}


	/**
	 * Get the JSON for the data constructed in this instance.
	 * 
	 * Basically the same as the {@link data} method, but in this case we echo, or
	 * return the JSON string of the data.
	 *  @param boolean $print Echo the JSON string out (true, default) or return it
	 *    (false).
	 *  @return string|self self if printing the JSON, or JSON representation of 
	 *    the processed data if false is given as the first parameter.
	 */
	public function json ( $print=true )
	{
		if ( $print ) {
			echo json_encode( $this->_out );
			return $this;
		}
		return json_encode( $this->_out );
	}


	/**
	 * Add a left join condition to the Editor instance, allowing it to operate
	 * over multiple tables. Multiple `leftJoin()` calls can be made for a
	 * single Editor instance to join multiple tables.
	 *
	 * A left join is the most common type of join that is used with Editor
	 * so this method is provided to make its use very easy to configure. Its
	 * parameters are basically the same as writing an SQL left join statement,
	 * but in this case Editor will handle the create, update and remove
	 * requirements of the join for you:
	 *
	 * * Create - On create Editor will insert the data into the primary table
	 *   and then into the joined tables - selecting the required data for each
	 *   table.
	 * * Edit - On edit Editor will update the main table, and then either
	 *   update the existing rows in the joined table that match the join and
	 *   edit conditions, or insert a new row into the joined table if required.
	 * * Remove - On delete Editor will remove the main row and then loop over
	 *   each of the joined tables and remove the joined data matching the join
	 *   link from the main table.
	 *
	 * Please note that when using join tables, Editor requires that you fully
	 * qualify each field with the field's table name. SQL can result table
	 * names for ambiguous field names, but for Editor to provide its full CRUD
	 * options, the table name must also be given. For example the field
	 * `first_name` in the table `users` would be given as `users.first_name`.
	 *
	 * @param string $table Table name to do a join onto
	 * @param string $field1 Field from the parent table to use as the join link
	 * @param string $operator Join condition (`=`, '<`, etc)
	 * @param string $field2 Field from the child table to use as the join link
	 * @return self Self for chaining.
	 *
	 * @example 
	 *    Simple join:
	 *    <code>
	 *        ->field( 
	 *          Field::inst( 'users.first_name as myField' ),
	 *          Field::inst( 'users.last_name' ),
	 *          Field::inst( 'users.dept_id' ),
	 *          Field::inst( 'dept.name' )
	 *        )
	 *        ->leftJoin( 'dept', 'users.dept_id', '=', 'dept.id' )
	 *        ->process($_POST)
	 *        ->json();
	 *    </code>
	 *
	 *    This is basically the same as the following SQL statement:
	 * 
	 *    <code>
	 *      SELECT users.first_name, users.last_name, user.dept_id, dept.name
	 *      FROM users
	 *      LEFT JOIN dept ON users.dept_id = dept.id
	 *    </code>
	 */
	public function leftJoin ( $table, $field1, $operator, $field2 )
	{
		$this->_leftJoin[] = array(
			"table"    => $table,
			"field1"   => $field1,
			"field2"   => $field2,
			"operator" => $operator
		);

		return $this;
	}


	/**
	 * Get / set the table name.
	 * 
	 * The table name designated which DB table Editor will use as its data
	 * source for working with the database. Table names can be given with an
	 * alias, which can be used to simplify larger table names. The field
	 * names would also need to reflect the alias, just like an SQL query. For
	 * example: `users as a`.
	 *
	 *  @param string|array $_,... Table names given as a single string, an array of
	 *    strings or multiple string parameters for the function.
	 *  @return string[]|self Array of tables names, or self if used as a setter.
	 */
	public function table ( $_=null )
	{
		if ( $_ !== null && !is_array($_) ) {
			$_ = func_get_args();
		}
		return $this->_getSet( $this->_table, $_, true );
	}


	/**
	 * Get / set the primary key.
	 *
	 * The primary key must be known to Editor so it will know which rows are being
	 * edited / deleted upon those actions. The default value is 'id'.
	 *  @param string $_ Primary key's name. If not given, then used as a getter.
	 *  @return string|self Primary key value if no parameter is given, or
	 *    self if used as a setter.
	 */
	public function pkey ( $_=null )
	{
		return $this->_getSet( $this->_pkey, $_ );
	}


	/**
	 * Process a request from the Editor client-side to get / set data.
	 *  @param array $data Typically $_POST or $_GET as required by what is sent by Editor
	 *  @return self
	 */
	public function process ( $data )
	{
		$this->_processData = $data;
		$this->_formData = isset($data['data']) ? $data['data'] : null;

		$this->_db->transaction();

		try {
			$this->_prepJoin();

			if ( !isset($data['action']) ) {
				/* Get data */
				$this->_out = array_merge( $this->_out, $this->_get( null, $data ) );
			}
			else if ( $data['action'] == "remove" ) {
				/* Remove rows */
				$this->_remove( $data );
			}
			else {
				/* Create or edit row */
				$valid = $this->validate( $this->_out['fieldErrors'], $data );

				// Global validation - if you want global validation - do it here
				// $this->_out['error'] = "";

				if ( $valid ) {
					if ( $data['action'] == "create" ) {
						$this->_out['row'] = $this->_insert();
					}
					else {
						$this->_out['row'] = $this->_update( $data['id'] );
					}
				}
			}

			$this->_db->commit();
		}
		catch (\Exception $e) {
			// Error feedback
			$this->_out['error'] = $e->getMessage();
			$this->_db->rollback();
		}

		// Tidy up the reply
		if ( count( $this->_out['fieldErrors'] ) === 0 ) {
			unset( $this->_out['fieldErrors'] );
		}

		if ( isset($data['action']) && count( $this->_out['data'] ) === 0 ) {
			unset( $this->_out['data'] );
		}

		if ( $this->_out['error'] === '' ) {
			unset( $this->_out['error'] );
		}

		// Not required in the Editor libraries
		unset( $this->_out['id'] );

		return $this;
	}


	/**
	 * Perform validation on a data set.
	 *
	 * Note that validation is performed on data only when the action is
	 * `create` or `edit`. Additionally, validation is performed on the _wire
	 * data_ - i.e. that which is submitted from the client, without formatting.
	 * Any formatting required by `setFormatter` is performed after the data
	 * from the client has been validated.
	 *
	 *  @param &array $errors Output array to which field error information will
	 *      be written. Each element in the array represents a field in an error
	 *      condition. These elements are themselves arrays with two properties
	 *      set; `name` and `status`.
	 *  @param array $data The format data to check
	 *  @return boolean `true` if the data is valid, `false` if not.
	 */
	public function validate ( &$errors, $data )
	{
		// Validation is only performs on create and edit
		if ( $data['action'] != "create" && $data['action'] != "edit" ) {
			return true;
		}

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];
			$validation = $field->validate( $data['data'], $this );

			if ( $validation !== true ) {
				$errors[] = array(
					"name" => $field->name(),
					"status" => $validation
				);
			}
		}

		return count( $errors ) > 0 ? false : true;
	}


	/**
	 * Where condition to add to the query used to get data from the database.
	 * 
	 * Can be used in two different ways, as where( field, value ) or as an array of
	 * conditions to use: where( array('fieldName', ...), array('value', ...) );
	 *
	 * Please be very careful when using this method! If an edit made by a user using
	 * Editor removes the row from the where condition, the result is undefined (since
	 * Editor expects the row to still be available, but the condition removes it from
	 * the result set).
	 *  @param string|string[] $key   Single field name, or an array of field names.
	 *  @param string|string[] $value Single field value, or an array of values.
	 *  @param string          $op    Condition operator: <, >, = etc
	 *  @return string[]|self Where condition array, or self if used as a setter.
	 */
	public function where ( $key=null, $value=null, $op='=' )
	{
		if ( $key === null ) {
			return $this->_where;
		}

		$this->_where[] = array(
			"key"   => $key,
			"value" => $value,
			"op"    => $op
		);

		return $this;
	}


	/**
	 * Get / set if the WHERE conditions should be included in the create and
	 * edit actions.
	 * 
	 * This means that the fields which have been used as part of the 'get'
	 * WHERE condition (using the `where()` method) will be set as the values
	 * given. *Note* The value given for the where operation is what will be
	 * set in the database, regardless of the condition operator given (the
	 * optional third parameter for the `where()` method).
	 *
	 * This is default false (i.e. they are not included).
	 *
	 *  @param boolean $_ Include (`true`), or not (`false`)
	 *  @return boolean Current value
	 */
	public function whereSet ( $_=null )
	{
		return $this->_getSet( $this->_whereSet, $_ );
	}



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods
	 */

	/**
	 * Get an array of objects from the database to be given to DataTables as a
	 * result of an sAjaxSource request, such that DataTables can display the information
	 * from the DB in the table.
	 *  @param integer $id Primary key value to get an individual row (after create or
	 *    update operations). Gets the full set if not given.
	 *  @param array $http HTTP parameters from GET or POST request (so we can service
	 *    server-side processing requests from DataTables).
	 *  @private
	 */
	private function _get( $id=null, $http=null )
	{
		$query = $this->_db
			->query('select')
			->table( $this->_table )
			->get( $this->_pkey )
			->get( $this->_fields('get') );

		$this->_get_where( $query );
		$this->_left_join( $query );
		$ssp = $this->_ssp_query( $query, $http );

		if ( $id !== null ) {
			$query->where( $this->_pkey, $id );
		}

		$res = $query->exec();
		if ( ! $res ) {
			throw new \Exception('Error executing SQL for data get');
		}

		$out = array();
		while ( $row=$res->fetch() ) {
			$inner = array();
			$inner['DT_RowId'] = $this->_idPrefix . $row[ $this->_pkey ];

			for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
				$field = $this->_fields[$i];

				if ( $field->apply('get') ) {
					$field->write( $inner, $row );
				}
			}

			$out[] = $inner;
		}

		// Row based "joins"
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->data( $this->_db, $this->table(), $this->pkey(),
				$this->idPrefix(), $out
			);
		}

		return array_merge( array('data'=>$out), $ssp );
	}


	/**
	 * Insert a new row in the database
	 *  @private
	 */
	private function _insert( )
	{
		// Insert the new row
		$id = $this->_insert_or_update( null );

		// Was the primary key sent? Unusual, but it is possible
		if ( isset( $this->_formData[ $this->_pkey ] ) ) {
			$id = $this->_formData[ $this->_pkey ];
		}

		// Join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->create( $this->_db, $id, $this->_formData );
		}

		// Full data set for the created
		$row = $this->_get( $id );
		return count( $row['data'] ) > 0 ?
			$row['data'][0] :
			null;
	}


	/**
	 * Update a row in the database
	 *  @param string $id The DOM ID for the row that is being edited.
	 *  @private
	 */
	private function _update( $id )
	{
		$id = str_replace( $this->_idPrefix, '', $id );

		// Update or insert the rows for the parent table and the left joined
		// tables
		$this->_insert_or_update( $id );

		// And the join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->update( $this->_db, $id, $this->_formData );
		}

		// Was the primary key altered as part of the edit? Unusual, but it is
		// possible
		$getId = isset( $this->_formData[ $this->_pkey ] ) ?
			$this->_formData[ $this->_pkey ] :
			$id;

		// Full data set for the modified row
		$row = $this->_get( $getId );
		return count( $row['data'] ) > 0 ?
			$row['data'][0] :
			null;
	}


	/**
	 * Delete one or more rows from the database
	 *  @private
	 */
	private function _remove( $data )
	{
		$inIds = is_array( $data['id'] ) ?
			$data['id'] :
			array( $data['id'] );

		if ( count( $inIds ) === 0 ) {
			throw new \Exception('No ids submitted for the delete');
		}

		// Strip the ID prefix that the client-side sends back
		for ( $i=0 ; $i<count($inIds) ; $i++ ) {
			$ids[] = str_replace( $this->_idPrefix, "", $inIds[$i] );
		}

		// Remove from the primary tables
		for ( $i=0, $ien=count($this->_table) ; $i<$ien ; $i++ ) {
			$this->_remove_table( $this->_table[$i], $ids );
		}

		// Remove from the left join tables
		for ( $i=0, $ien=count($this->_leftJoin) ; $i<$ien ; $i++ ) {
			$join = $this->_leftJoin[$i];
			$table = $this->_alias( $join['table'], 'orig' );

			// which side of the join refers to the parent table?
			if ( strpos( $join['field1'], $join['table'] ) === 0 ) {
				$parentLink = $join['field2'];
				$childLink = $join['field1'];
			}
			else {
				$parentLink = $join['field1'];
				$childLink = $join['field2'];
			}

			// Only delete on the primary key, since that is what the ids refer
			// to - otherwise we'd be deleting random data!
			if ( $parentLink === $this->_pkey ) {
				$this->_remove_table( $this->_leftJoin[$i]['table'], $ids, $childLink );
			}
		}

		// And from the join tables
		for ( $i=0 ; $i<count($this->_join) ; $i++ ) {
			$this->_join[$i]->remove( $this->_db, $ids );
		}
	}
	

	/**
	 * Create an array of the DB fields to use for a get / set operation.
	 *  @param string $direction Direction: 'get' or 'set'.
	 *  @return array List of fields
	 *  @private
	 */
	private function _fields ( $direction )
	{
		$fields = array();

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];

			if ( $field->apply( $direction, $this->_formData ) ) {
				$fields[] = $field->dbField();
			}
		}

		return $fields;
	}


	/*  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *
	 * Server-side processing methods
	 */

	/**
	 * When server-side processing is being used, modify the query with // the
     * required extra conditions
	 *
	 *  @param Query $query Query instance to apply the SSP commands to
	 *  @return array Server-side processing information array
	 *  @private
	 */
	private function _ssp_query ( $query, $http )
	{
		$ssp = array();
		
		if ( ! isset( $http['draw'] ) ) {
			return array();
		}

		// Add the server-side processing conditions
		$this->_ssp_limit( $query, $http );
		$this->_ssp_sort( $query, $http );
		$this->_ssp_filter( $query, $http );

		// Get the number of rows in the result set
		$ssp_set_count = $this->_db
			->query('select')
			->table( $this->_table )
			->get( 'COUNT('.$this->_pkey.') as cnt' );
		$this->_get_where( $ssp_set_count );
		$this->_ssp_filter( $ssp_set_count, $http );
		$this->_left_join( $ssp_set_count );
		$ssp_set_count = $ssp_set_count->exec()->fetch();

		// Get the number of rows in the full set
		$ssp_full_count = $this->_db
			->query('select')
			->table( $this->_table )
			->get( 'COUNT('.$this->_pkey.') as cnt' );
		$this->_get_where( $ssp_full_count );
		if ( count( $this->_where ) ) { // only needed if there is a where condition
			$this->_left_join( $ssp_full_count );
		}
		$ssp_full_count = $ssp_full_count->exec()->fetch();

		return array(
			"draw" => intval( $http['draw'] ),
			"recordsTotal" => $ssp_full_count['cnt'],
			"recordsFiltered" => $ssp_set_count['cnt']
		);
	}


	/**
	 * Convert a column index to a database field name - used for server-side
	 * processing requests.
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @param int $index Index in the DataTables' submitted data
	 *  @returns string DB field name
	 *  @private // It is actually public for PHP 5.3 compatibility with a closure
	 */
	public function _ssp_field( $http, $index )
	{
		$name = $http['columns'][$index]['data'];
		$field = $this->_find_field( $name, 'name' );

		if ( ! $field ) {
			throw new \Exception('Unknown field: '.$name .' (index '.$index.')');
		}

		return $field->dbField();
	}


	/**
	 * Sorting requirements to a server-side processing query.
	 *  @param Query $query Query instance to apply sorting to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_sort ( $query, $http )
	{
		for ( $i=0 ; $i<count($http['order']) ; $i++ ) {
			$order = $http['order'][$i];

			$query->order(
				$this->_ssp_field( $http, $order['column'] ) .' '.
				($order['dir']==='asc' ? 'asc' : 'desc')
			);
		}
	}


	/**
	 * Add DataTables' 'where' condition to a server-side processing query. This
	 * works for both global and individual column filtering.
	 *  @param Query $query Query instance to apply the WHERE conditions to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_filter ( $query, $http )
	{
		$that = $this;

		// Global filter
		$fields = $this->_fields;

		// Global search, add a ( ... or ... ) set of filters for each column
		// in the table (not the fields, just the columns submitted)
		if ( $http['search']['value'] ) {
			$query->where( function ($q) use (&$that, &$fields, $http) {
				for ( $i=0 ; $i<count($http['columns']) ; $i++ ) {
					if ( $http['columns'][$i]['searchable'] == 'true' ) {
						$field = $that->_ssp_field( $http, $i );

						$q->or_where( $field, '%'.$http['search']['value'].'%', 'like' );
					}
				}
			} );
		}

		// Column filters
		for ( $i=0, $ien=count($http['columns']) ; $i<$ien ; $i++ ) {
			$column = $http['columns'][$i];
			$search = $column['search']['value'];

			if ( $search && $column['searchable'] == 'true' ) {
				$query->where( $this->_ssp_field( $http, $i ), '%'.$search.'%', 'like' );
			}
		}
	}


	/**
	 * Add a limit / offset to a server-side processing query
	 *  @param Query $query Query instance to apply the offset / limit to
	 *  @param array $http HTTP variables (i.e. GET or POST)
	 *  @private
	 */
	private function _ssp_limit ( $query, $http )
	{
		if ( $http['start'] != -1 ) { // -1 is 'show all' in DataTables
			$query
				->offset( $http['start'] )
				->limit( $http['length'] );
		}
	}


	/*  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *  *
	 * Internal helper methods
	 */

	/**
	 * Add left join commands for the instance to a query.
	 *
	 *  @param Query $query Query instance to apply the joins to
	 *  @private
	 */
	private function _left_join ( $query )
	{
		if ( count($this->_leftJoin) ) {
			for ( $i=0, $ien=count($this->_leftJoin) ; $i<$ien ; $i++ ) {
				$join = $this->_leftJoin[$i];

				$query->join( $join['table'], $join['field1'].' '.$join['operator'].' '.$join['field2'], 'LEFT' );
			}
		}
	}


	/**
	 * Add local WHERE condition to query
	 *  @param Query $query Query instance to apply the WHERE conditions ti
	 *  @private
	 */
	private function _get_where ( $query )
	{
		for ( $i=0 ; $i<count($this->_where) ; $i++ ) {
			$query->where(
				$this->_where[$i]['key'],
				$this->_where[$i]['value'],
				$this->_where[$i]['op']
			);
		}
	}


	/**
	 * Get a field instance from a known field name
	 *
	 *  @param string $name Field name
	 *  @return Field Field instance
	 *  @private
	 */
	private function _find_field ( $name, $type )
	{
		for ( $i=0, $ien=count($this->_fields) ; $i<$ien ; $i++ ) {
			$field = $this->_fields[ $i ];

			if ( $type === 'name' && $field->name() === $name ) {
				return $field;
			}
			else if ( $type === 'db' && $field->dbField() === $name ) {
				return $field;
			}
		}

		return null;
	}


	/**
	 * Get the table name from an SQL field name. Will throw an error if there
	 * is no table name.
	 *
	 *  @param string $name SQL field name to check.
	 *  @private
	 */
	private function _table_part ( $name )
	{
		if ( strpos( $name, '.' ) === false ) {
			throw new \Exception( 'Table part of the field '.$name.' was not found.'.
				' In Editor instances that use a join, all fields must have the '.
				' database table set explicitly. For example the field `'.$field->dbField().'`'.
				' might be: `'.$this->_alias( $this->_table[0], 'orig' ).'.'.$field->dbField().'`'
			);
		}
	}


	/**
	 * Insert or update a row for all main tables and left joined tables.
	 *
	 *  @param int $id ID to use to condition the update. If null is given, the
	 *      first query performed is an insert and the inserted id used as the
	 *      value should there be any subsequent tables to operate on.
	 *  @return Database.Result Result from the query or null if no query
	 *      performed.
	 *  @private
	 */
	private function _insert_or_update ( $id )
	{
		// Loop over all tables in _table, doing the insert or update as needed
		for ( $i=0, $ien=count( $this->_table ) ; $i<$ien ; $i++ ) {
			$res = $this->_insert_or_update_table(
				$this->_table[$i],
				$id === null ?
					null :
					array($this->_pkey => $id)
			);

			// If we don't have an id yet, then the first insert will return
			// the id we want
			if ( $id === null ) {
				$id = $res->insertId();
			}
		}

		// And for the left join tables as well
		for ( $i=0, $ien=count( $this->_leftJoin ) ; $i<$ien ; $i++ ) {
			$join = $this->_leftJoin[$i];

			// which side of the join refers to the parent table?
			$joinTable = $this->_alias( $join['table'], 'alias' );
			$tablePart = $this->_part( $join['field1'] );

			if ( $this->_part( $join['field1'], 'db' ) ) {
				$tablePart = $this->_part( $join['field1'], 'db' ).'.'.$tablePart;
			}

			if ( $tablePart === $joinTable ) {
				$parentLink = $join['field2'];
				$childLink = $join['field1'];
			}
			else {
				$parentLink = $join['field1'];
				$childLink = $join['field2'];
			}

			if ( $parentLink === $this->_pkey ) {
				$where = array( $childLink => $id );
			}
			else {
				$field = $this->_find_field( $parentLink, 'db' );
				if ( ! $field ) {
					// The parent field wasn't included in the field list, so
					// nothing can be done with it
					continue;
				}

				$where = array( $childLink => $field->val('set', $this->_formData) );
			}

			$this->_insert_or_update_table( $join['table'], $where );
		}

		return $id;
	}


	/**
	 * Insert or update a row in a single database table, based on the data
	 * given and the fields configured for the instance.
	 *
	 * The function will find the fields which are required for this specific
	 * table, based on the names of fields and use only the appropriate data for
	 * this table. Therefore the full submitted data set can be passed in.
	 *
	 *  @param string $table Database table name to use (can include an alias)
	 *  @param array $where Update condition
	 *  @return Database.Result Result from the query or null if no query
	 *      performed.
	 *  @private
	 */
	private function _insert_or_update_table ( $table, $where=null )
	{
		$set = array();
		$tableName = $this->_alias( $table, 'orig' );
		$tableAlias = $this->_alias( $table, 'alias' );

		for ( $i=0 ; $i<count($this->_fields) ; $i++ ) {
			$field = $this->_fields[$i];
			$tablePart = $this->_part( $field->dbField() );

			if ( $this->_part( $field->dbField(), 'db' ) ) {
				$tablePart = $this->_part( $field->dbField(), 'db' ).'.'.$tablePart;
			}

			// Does this field apply to this table (only check when a join is
			// being used)
			if ( count($this->_leftJoin) && $tablePart !== $tableAlias ) {
				continue;
			}

			// Check if this field should be set, based on options and
			// submitted data
			if ( ! $field->apply( 'set', $this->_formData ) ) {
				continue;
			}

			// Some db's (specifically postgres) don't like having the table
			// name prefixing the column name. TODO it might be nicer to have
			// the db layer abstract this out?
			$fieldPart = $this->_part( $field->dbField(), 'field' );
			$set[ $fieldPart ] = $field->val('set', $this->_formData);

			// Add where fields if setting where values and required for this
			// table
			if ( $this->_whereSet ) {
				for ( $j=0, $jen=count($this->_where) ; $j<$jen ; $j++ ) {
					$cond = $this->_where[$j];

					if ( $tableAlias === $this->_table_part( $cond['key'] ) && ! isset( $set[ $cond['key'] ] ) ) {
						$set[ $cond['key'] ] = $cond['value'];
					}
				}
			}
		}

		// If nothing to do, then do nothing!
		if ( ! count( $set ) ) {
			return null;
		}

		// Insert or update
		if ( $where === null ) {
			return $this->_db->insert( $this->_table, $set );
		}
		else {
			return $this->_db->push( $table, $set, $where );
		}
	}


	/**
	 * Delete one or more rows from the database for an individual table
	 *
	 *  @param string $table Database table name to use
	 *  @param array $ids Array of ids to remove
	 *  @param string $pkey Database column name to match the ids on for the
	 *    delete condition. If not given the instance's base primary key is
	 *    used.
	 *  @private
	 */
	function _remove_table ( $table, $ids, $pkey=null )
	{
		if ( $pkey === null ) {
			$pkey = $this->_pkey;
		}

		$stmt = $this->_db
			->query( 'delete' )
			->table( $table )
			->or_where( $pkey, $ids )
			->exec();
	}


	/**
	 * Check the validity of the set options if  we are doing a join, since
	 * there are some conditions for this state. Will throw an error if not
	 * valid.
	 *
	 *  @private
	 */
	private function _prepJoin ()
	{
		if ( count( $this->_leftJoin ) === 0 ) {
			return;
		}

		// Check if the primary key has a table identifier - if not - add one
		if ( strpos( $this->_pkey, '.' ) === false ) {
			$this->_pkey = $this->_alias( $this->_table[0], 'alias' ).'.'.$this->_pkey;
		}

		// Check that all fields have a table selector, otherwise, we'd need to
		// know the structure of the tables, to know which fields belong in
		// which. This extra requirement on the fields removes that
		for ( $i=0, $ien=count($this->_fields) ; $i<$ien ; $i++ ) {
			$field = $this->_fields[$i];

			$this->_table_part( $field->dbField() ); // will throw an error if no table part
		}
	}


	/**
	 * Get one side or the other of an aliased SQL field name.
	 *
	 *  @param string $name SQL field
	 *  @param string $type Which part to get: `alias` (default) or `orig`.
	 *  @private
	 */
	private function _alias ( $name, $type='alias' )
	{
		if ( strpos( $name, ' as ' ) === false ) {
			return $name;
		}

		$a = explode( ' as ', $name );
		return $type === 'alias' ?
			$a[1] :
			$a[0];
	}


	/**
	 * Get part of an SQL field definition regardless of how deeply defined it
	 * is
	 *
	 *  @param string $name SQL field
	 *  @param string $type Which part to get: `table` (default) or `db` or
	 *      `column`
	 *  @private
	 */
	private function _part ( $name, $type='table' )
	{
		$db = null;
		$table = null;
		$column = null;

		if ( strpos( $name, '.' ) !== false ) {
			$a = explode( '.', $name );

			if ( count($a) === 3 ) {
				$db = $a[0];
				$table = $a[1];
				$column = $a[2];
			}
			else if ( count($a) === 2 ) {
				$table = $a[0];
				$column = $a[1];
			}
		}
		else {
			$column = $name;
		}

		if ( $type === 'db' ) {
			return $db;
		}
		else if ( $type === 'table' ) {
			return $table;
		}
		return $column;
	}
}


/**
 * Base class for DataTables classes.
 */
class Ext {
	/**
	 * Static method to instantiate a new instance of a class.
	 *
	 * A factory method that will create a new instance of the class
	 * that has extended 'Ext'. This allows classes to be instantiated
	 * and then chained - which otherwise isn't available until PHP 5.4.
	 * If using PHP 5.4 or later, simply create a 'new' instance of the
	 * target class and chain methods as normal.
	 *  @return Instantiated class
	 *  @static
	 */
	public static function instantiate ()
	{
		$rc = new \ReflectionClass( get_called_class() );
		return $rc->newInstanceArgs( func_get_args() );
	}

	/**
	 * Static method to instantiate a new instance of a class (shorthand of 
	 * 'instantiate').
	 *
	 * This method performs exactly the same actions as the 'instantiate'
	 * static method, but is simply shorter and easier to type!
	 *  @return Instantiated class
	 *  @static
	 */
	public static function inst ()
	{
		$rc = new \ReflectionClass( get_called_class() );
		return $rc->newInstanceArgs( func_get_args() );
	}

	/**
	 * Common getter / setter function for DataTables classes.
	 *
	 * This getter / setter method makes building getter / setting methods
	 * easier, by abstracting everything to a single function call.
	 *  @param mixed &$prop The property to set
	 *  @param mixed $val The value to set - if given as null, then we assume
	 *    that the function is being used as a getter.
	 *  @param boolean $array Treat the target property as an array or not
	 *    (default false). If used as an array, then values passed in are added
	 *    to the $prop array.
	 *  @return self|* Class instance if setting (allowing chaining), or
	 *    the value requested if getting.
	 *  @internal
	 */
	protected function _getSet( &$prop, $val, $array=false )
	{
		// Get
		if ( $val === null ) {
			return $prop;
		}

		// Set
		if ( $array ) {
			// Property is an array, merge or add to array
			is_array( $val ) ?
				$prop = array_merge( $prop, $val ) :
				$prop[] = $val;
		}
		else {
			// Property is just a value
			$prop = $val;
		}

		return $this;
	}
}