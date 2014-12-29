<?php if ( ! defined('SZ_EXEC') ) exit('access_denied');

/**
 * ====================================================================
 * 
 * Seezoo-Framework
 * 
 * A simple MVC/action Framework on PHP 5.1.0 or newer
 * 
 * 
 * Variable verification method
 * 
 * @package  Seezoo-Framework
 * @category Library
 * @author   Yoshiaki Sugimoto <neo.yoshiaki.sugimoto@gmail.com>
 * @license  MIT Licence
 * 
 * ====================================================================
 */

class Base_Verify extends SZ_Verify
{
	/**
	 * Error messages
	 * @var array
	 */
	public $messages = array(
		'alnum'       => '%sは半角英数で入力してください。',
		'alnum_dash'  => '%sは半角英数で入力してください。',
		'alpha'       => '%sは半角英字で入力してください。',
		'alpha_dash'  => '%sは半角英字で入力してください。',
		'alpha_lower' => '%sは半角英小文字で入力してください。',
		'alpha_upper' => '%sは半角英大文字で入力してください。',
		'dateformat'  => '%sの日付の形式が正しくありません。',
		'exact_date'  => '%sには実在する日付を入力してください。',
		'future_date' => '%sに過去の日付は指定できません。',
		'hiragana'    => '%sはひらがなで入力してください。',
		'kana'        => '%sはカタカナで入力してください。',
		'max_length'  => '%s must be less than %s length',
		'min_length'  => '%s must be greater than %s length',
		'numeric'     => '%sは数値で入力してください。',
		'past_date'   => '%sに未来の日付は指定できません。。',
		'range'       => '%sは%sから%sの間で指定してください。',
		'telnumber'   => '%sの形式が正しくありません',
		'unsigned'    => '%sに正の数値を入力してください。',
		'zipcode'     => '%sの郵便番号の形式が正しくありません。',
		'required'    => '%s is required.',
		'blank'       => '%sは空欄にしてください。',
		'ctype'       => '%sは半角数字で入力してください。',
		'valid_email' => '%s is invalid format',
		'valid_url'   => '%sのURL形式が正しくありません。',
		'regex'       => '%sの形式が正しくありません。',
		'matches'     => '%s value is not match of %s.'
	);
}
