<?php
namespace Llama\Configuration\Reader;

use Llama\Configuration;
use Llama\Configuration\Reader\Exception;

/**
 * .ini configuration file reader for use in Llama\Configuration.
 *
 * @category   Llama
 * @package    Configuration
 * @subpackage Reader
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses \Llama\Configuration
 * @uses \Llama\Configuration\Reader\Exception
 */
class INI extends Configuration
{

    /**
     * Constructor
     *
     * Setup the INI object.
     *
     * @param string          $filePath The path to the .ini file.
     * @param mixed[optional] $section  The section of the .ini to load
     *
     * @access public
     * @throws \Llama\Configuration\Reader\Exception
     */
    public function __construct($filePath, $section = null)
    {
        if (!file_exists($filePath)) {
            throw new Exception('Specified .ini file (' . $filePath . ') does not exist.');
        }

        $iniArray = $this->loadIniFile($filePath);
        $dataArray = array();

        if ($section === null) {
            foreach ($iniArray as $sectionName => $sectionData) {
                if (is_array($sectionData)) {
                    $dataArray[$sectionName] = $this->processSection($iniArray, $sectionName);
                } else {
                    $dataArray = $this->arrayMergeRecursive(
                        $dataArray,
                        $this->processKey(
                            array(),
                            $sectionName,
                            $sectionData
                        )
                    );
                }
            }
        } else {
            if (!is_array($section)) {
                $section = array($section);
            }

            foreach ($section as $sectionName) {
                if (!isset($iniArray[$sectionName])) {
                    throw new Exception('Could not find section (' . $sectionName . ')');
                }

                $dataArray = $this->arrayMergeRecursive($this->processSection($iniArray, $sectionName), $dataArray);
            }
        }

        parent::__construct($dataArray);
    }

    /**
     * Loads the .ini file into an array.
     *
     * @param string $filePath The path to the .ini file.
     *
     * @access private
     * @throws \Llama\Configuration\Reader\Exception
     * @return array
     */
    private function loadIniFile($filePath)
    {
        $loaded = parse_ini_file($filePath, true);
        $iniArray = array();

        foreach ($loaded as $key => $data) {
            $sections = explode(':', $key);
            $key = trim($sections[0]);

            switch (sizeof($sections)) {
                case 1:
                    $iniArray[$key] = $data;
                    break;
                case 2:
                    $iniArray[$key] = array_merge(array(';extends' => trim($sections[1])), $data);
                    break;
                default:
                    throw new Exception('Configuration can\'t contain more than one extension');
            }
        }

        return $iniArray;
    }

    /**
     * Splits a period separated key into a child array for each part of the key.
     *
     * @param array  $config An array a section from the .ini file.
     * @param string $key    The key of the ini directive.
     * @param string $data   The value of the ini directive.
     *
     * @access private
     * @return array
     */
    private function processKey($config, $key, $data)
    {
        if (strpos($key, '.') !== false) {
            $pieces = explode('.', $key, 2);

            if (!array_key_exists($pieces[0], $config)) {
                $config[$pieces[0]] = array();
            }

            $config[$pieces[0]] = $this->processKey($config[$pieces[0]], $pieces[1], $data);
        } else {
            $config[$key] = $data;
        }

        return $config;
    }

    /**
     * Returns a section of the .ini file data with it's dependant sections.
     *
     * @param array           $iniArray The file data in an array.
     * @param string          $section  The section in the file data to load.
     * @param array[optional] $config   The base array to add the data to.
     *
     * @access private
     * @throws \Llama\Configuration\Reader\Exception
     * @return array
     */
    private function processSection($iniArray, $section, $config = array())
    {
        foreach ($iniArray[$section] as $key => $value) {
            if ($key == ';extends') {
                if (!isset($iniArray[$value])) {
                    throw new Exception('Parent section not found (' . $value . ')');
                }

                $config = $this->processSection($iniArray, $value, $config);
            } else {
                $config = $this->processKey($config, $key, $value);
            }
        }

        return $config;
    }
}

