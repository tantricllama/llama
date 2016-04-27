<?php
namespace Llama;

/**
 * Locale class for use in Llama.
 *
 * @category Llama
 * @package  Locale
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
class Locale
{

    /**
     * The locale to use with GetText (e.g., en_AU, uk_UA).
     *
     * @access private
     * @var    string
     */
    private $locale;

    /**
     * The directory storing the locale files.
     *
     * @access private
     * @var    string
     */
    private $path;

    /**
     * The character set to use when binding domains.
     *
     * @access private
     * @var    string
     */
    private $charset = 'UTF-8';

    /**
     * A list of domains with the locale directory.
     *
     * @access private
     * @var    array
     */
    private $boundDomains = array();

    /**
     * Specifies if the locale has been set in the server environment.
     *
     * @access private
     * @var    bool
     */
    private $initialised = false;

    /**
     * Constructor
     *
     * Setup the Locale object.
     *
     * @param string $locale The locale to use with GetText (e.g., en_AU, uk_UA).
     *
     * @access public
     */
    public function __construct($locale = null)
    {
        if (!is_null($locale)) {
            $this->setLocale($locale);
        }
    }

    /**
     * Set the locale.
     *
     * @param string $locale The locale to use with GetText (e.g., en_AU, uk_UA).
     *
     * @access public
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->initialised = false;
    }

    /**
     * Return the locale.
     *
     * @access public
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the path to the locale files.
     *
     * @param string $path The directory storing the locale files.
     *
     * @access public
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Return the path to the locale files.
     *
     * @access public
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the character set to be used for binding domains.
     *
     * @param string $charset The character set to use when binding domains.
     *
     * @access public
     * @return void
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Return the character set used when binding domains.
     *
     * @access public
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Returns the translated message, if found within the domain.
     *
     * @param string $domain  The domain the translation exists under.
     * @param string $message The msgID of the translated string.
     *
     * @access public
     * @return string
     */
    public function translate($domain, $message)
    {
        $this->initLocale();
        $this->bindDomain($domain);

        $args = func_get_args();
        $text = dgettext($domain, $message);

        if (sizeof($args) <= 2) {
            return $text;
        }

        $params = array_slice($args, 2);

        array_unshift($params, $text);

        return call_user_func_array('sprintf', $params);
    }

    /**
     * Initialises the locale in the server environment.
     *
     * @access private
     * @return void
     */
    private function initLocale()
    {
        if (!$this->initialised) {
            putenv("LANG=$this->locale");
            setlocale(LC_ALL, $this->locale);

            $this->initialised = true;
        }
    }

    /**
     * Bind a specified domain to the locale file path and set the character set.
     *
     * @param string $domain The domain to bind the path to.
     *
     * @access private
     * @return void
     */
    private function bindDomain($domain)
    {
        if (!in_array($domain, $this->boundDomains)) {
            bindtextdomain($domain, $this->path);
            bind_textdomain_codeset($domain, $this->charset);

            $this->boundDomains[] = $domain;
        }
    }

    // -- Magic Methods

    /**
     * Return the locale when the object is used in a string context.
     *
     * @magic
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->getLocale();
    }
}

