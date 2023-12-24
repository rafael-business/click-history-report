<?php
/**
 * Implements cc command.
 */
class CC_Command {

    /**
     * Prints a report with the history of clicks on the Click Counter Button plugin button.
     *
     * ## OPTIONS
     *
     * <limit>
     * : The limit of records.
     * 
     * [--order=<order>]
     * : The order to show records.
     * ---
     * default: ASC
     * options:
     *   - ASC
     *   - DESC
     * ---
     *
     * ## EXAMPLES
     *
     *     wp cc report 10
     *
     * @when after_wp_load
     */
    function report( $args, $assoc_args ) {
        list( $limit ) = $args;

        $order = $assoc_args['order'];
        $order_txt = $order === 'ASC' ? __( 'the first', 'click-history-report' ) : __( 'the last', 'click-history-report' );

        $items = $this->get_click_history( $limit, $order );
        $qty = count( $items ) < $limit ? count( $items ) : $limit;
        
        if ( $items && ! empty( $items ) ) {
            WP_CLI\Utils\format_items( 'table', $items, array( 'id', 'click_date' ) );
            WP_CLI::success( __( 'The report with ', 'click-history-report' ) . $order_txt . ' ' . $qty . __( " click's is successfully generated!", 'click-history-report' ) );
        } else {
            WP_CLI::error( 'The report cannot be generated.', 'click-history-report' );
        }
    }

    /**
     * Get click history data from the database.
     *
     * @param int    $limit Limit of records.
     * @param string $order Order to show records (ASC or DESC).
     *
     * @return array
     */
    private function get_click_history( $limit, $order ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'click_counter';

        $sql = $wpdb->prepare(
            "SELECT * FROM $table_name ORDER BY click_date $order LIMIT %d",
            $limit
        );

        $results = $wpdb->get_results( $sql, ARRAY_A );

        foreach ( $results as &$result ) {
            $result['click_date'] = $this->convert_utc_to_local( $result['click_date'] );
        }

        return $results ?? [];
    }

    /**
     * Convert a UTC date and time to the WordPress local time zone.
     *
     * @param string $utc_date Date and time in UTC format.
     *
     * @return string Date and time in the WordPress local time zone.
     */
    private function convert_utc_to_local( $utc_date ) {
        $utc_timestamp = strtotime( $utc_date );
        return date_i18n( __( 'Y-d-m \a\t', 'click-history-report' ) .' H:i:s', $utc_timestamp );
    }
}

WP_CLI::add_command( 'cc', 'CC_Command' );