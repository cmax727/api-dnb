<?php
class ErrorHelper
{
	public static function add($error)
	{
		self::getCi()->error->addError($error);
	}
	
	public static function addMessage($message)
	{
		self::getCi()->error->addMessage($message);
	}
	
	public static function renderErrors($intoVar = false)
	{
		return self::getCi()->error->renderErrors($intoVar);
	}
  
  public static function renderMessages()
	{
		return self::getCi()->error->renderMessages();
	}
	
	public static function useScope($scope)
	{
		return self::getCi()->error->useScope($scope);
	}
	
	public static function hasErrors()
	{
		return self::getCi()->error->hasErrors();
	}
	
	public static function hasScopeErrors()
	{
		return self::getCi()->error->hasScopeErrors();
	}
	
	public static function transferScopeErrors()
	{
		return self::getCi()->error->transferScopeErrors();
	}
	
	public static function keep()
	{
		self::getCi()->error->keep();
	}
	
	private static function & getCi()
	{
		return get_instance();
	}
}
?>