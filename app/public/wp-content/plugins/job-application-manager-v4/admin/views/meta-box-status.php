<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="jam-status-box">
    <p>
        <label for="jam_status"><strong><?php esc_html_e( 'Application Status', 'jam' ); ?></strong></label><br>
        <select id="jam_status" name="jam_status" style="width:100%; margin-top:6px;">
            <?php foreach ( $statuses as $value => $label ) : ?>
                <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="jam_job_listing"><strong><?php esc_html_e( 'Position Applied For', 'jam' ); ?></strong></label><br>
        <input type="text" id="jam_job_listing" name="jam_job_listing" value="<?php echo esc_attr( $job ); ?>" style="width:100%; margin-top:6px;" placeholder="<?php esc_attr_e( 'e.g. Senior Nurse', 'jam' ); ?>">
    </p>

    <div class="jam-status-badge-wrap">
        <span class="jam-status-badge jam-status--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( $statuses[ $status ] ?? ucfirst( $status ) ); ?></span>
    </div>
</div>
