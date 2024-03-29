<?php

namespace WP_STATISTICS;

class Historical
{
    /**
     * List Of Historical Category
     *
     * @var array
     */
    public static $historical_cat = array(
        'visitors',
        'visits',
        'uri'
    );

    /**
     * Get historical data
     *
     * @param $type
     * @param string $id
     *
     * @return int|null|string
     */
    public static function get($type, $id = '')
    {
        global $wpdb;

        # Default Count
        $count = 0;

        # Create SQL
        switch ($type) {
            case 'uri':
                $sql = $wpdb->prepare("SELECT `value` FROM %i WHERE `category` = 'uri'", DB::table('historical'));
                break;
            case 'page':
                $sql = $wpdb->prepare("SELECT `value` FROM %i WHERE `category` = 'uri' AND `page_id` = %d", DB::table('historical'), $id);
                break;
            case 'visitors':
            case 'visits':
            default:
                $sql = $wpdb->prepare("SELECT `value` FROM %i WHERE `category` = %s", DB::table('historical'), $type);
                break;
        }

        # Get Count Dara
        $result = $wpdb->get_var($sql); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	

        # Return
        return $result > $count ? $result : $count;
    }

    /**
     * Check Is Empty Historical Table
     */
    public static function isEmpty()
    {
        global $wpdb;
        return ($wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM %i", DB::table('historical')) ) < 1);
    }

}