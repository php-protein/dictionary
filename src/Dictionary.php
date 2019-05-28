<?php declare(strict_types=1);

/**
 * Dictionary class
 *
 * The dictionary class allow to handle a repository of key-values data
 * Values are accessibles via a dot notation key path.
 *
 * Example:
 * <code>
 *  class State extends Dictionary {}
 *  State::set('user',[ 'name' => 'Frank', 'surname' => 'Castle' ]);
 *  echo "Hello, my name is ",State::get('user.name'),' ',State::get('user.surname');
 * </code>
 *
 * @package Protein
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 *
 */

namespace Protein;

abstract class Dictionary {

    protected static $fields = null;

    public static function & all() {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        return static::$fields->all();
    }

    public static function get($key, $default=null) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        if (is_array($key)) {
            $results = [];
            foreach ($key as $_dst_key => $_src_key) {
                $results[$_dst_key] = static::$fields->get($_src_key);
            }
            return $results;
        } else {
            return static::$fields->get($key, $default);
        }
    }

    public static function set($key, $value=null) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        return static::$fields->set($key, $value);
    }

    /**
     * @return void
     */
    public static function delete($key, $compact=true) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        static::$fields->delete($key, $compact);
    }

    public static function exists($key) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        return static::$fields->exists($key);
    }

    /**
     * @return void
     */
    public static function clear() {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        static::$fields->clear();
    }

    /**
     * @return void
     */
    public static function load($fields) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        static::$fields->load($fields);
    }

    /**
     * @return void
     */
    public static function merge(array $array, $merge_back=false) {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        static::$fields->merge($array, $merge_back);
    }

    /**
     * @return void
     */
    protected static function compact() {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        static::$fields->compact();
    }

    protected static function & find($path, $create=false, callable $operation=null) {
        return static::$fields->find($path, $create, $operation);
    }

    public function jsonSerialize() {
        if (!static::$fields) {
            static::$fields = new Map();
        }
        return static::$fields->jsonSerialize();
    }
}
