<?php if ( ! defined( 'ABSPATH' ) ) exit;

$app_type = get_post_meta( $post->ID, '_jam_application_type', true ) ?: 'standard';

function jam_doc_link_row( $attach_id, $label ) {
    echo '<tr><th>' . esc_html( $label ) . '</th><td>';
    if ( $attach_id && $url = wp_get_attachment_url( $attach_id ) ) {
        echo '<a href="' . esc_url( $url ) . '" target="_blank" class="button button-small jam-doc-download">';
        echo '<span class="dashicons dashicons-download"></span> ';
        echo esc_html( get_the_title( $attach_id ) );
        echo '</a>';
    } else {
        echo '<em>' . esc_html__( 'Not uploaded', 'jam' ) . '</em>';
    }
    echo '</td></tr>';
}
?>

<div class="jam-meta-details">

    <?php if ( 'intern' === $app_type ) : ?>

    <!-- ── Intern documents ─────────────────────────────────────────── -->
    <table class="jam-meta-table">
        <?php
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_cv_id', true ),           __( 'CV / Resume', 'jam' ) );
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_intro_letter_id', true ),  __( 'Introduction Letter', 'jam' ) );
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_transcript_id', true ),    __( 'Academic Transcript', 'jam' ) );
        ?>
    </table>

    <?php else : ?>

    <!-- ── Standard documents ────────────────────────────────────────── -->
    <table class="jam-meta-table">
        <?php
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_id_doc_id', true ),      __( 'ID / Passport Document', 'jam' ) );
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_reg_cert_id', true ),    __( 'Registration Certificate', 'jam' ) );
        jam_doc_link_row( get_post_meta( $post->ID, '_jam_license_cert_id', true ),__( 'License Certificate', 'jam' ) );
        ?>
    </table>

    <!-- Academic certificates (multiple) -->
    <?php
    $cert_ids = json_decode( get_post_meta( $post->ID, '_jam_certificates_ids', true ), true );
    if ( ! empty( $cert_ids ) && is_array( $cert_ids ) ) :
    ?>
    <h4 class="jam-meta-section-title" style="margin-top:16px;"><?php esc_html_e( 'Academic Certificates', 'jam' ); ?></h4>
    <ul class="jam-cert-list">
        <?php foreach ( $cert_ids as $i => $cid ) :
            $url  = wp_get_attachment_url( $cid );
            $name = get_the_title( $cid );
        ?>
        <li>
            <?php if ( $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" target="_blank" class="button button-small jam-doc-download">
                <span class="dashicons dashicons-download"></span>
                <?php echo esc_html( sprintf( __( 'Certificate %d – %s', 'jam' ), $i + 1, $name ) ); ?>
            </a>
            <?php else : ?>
            <em><?php esc_html_e( 'File not found', 'jam' ); ?></em>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <!-- Additional docs (multiple, optional) -->
    <?php
    $add_ids = json_decode( get_post_meta( $post->ID, '_jam_additional_docs_ids', true ), true );
    if ( ! empty( $add_ids ) && is_array( $add_ids ) ) :
    ?>
    <h4 class="jam-meta-section-title" style="margin-top:16px;"><?php esc_html_e( 'Additional Documents', 'jam' ); ?></h4>
    <ul class="jam-cert-list">
        <?php foreach ( $add_ids as $i => $did ) :
            $url  = wp_get_attachment_url( $did );
            $name = get_the_title( $did );
        ?>
        <li>
            <?php if ( $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" target="_blank" class="button button-small jam-doc-download">
                <span class="dashicons dashicons-download"></span>
                <?php echo esc_html( sprintf( __( 'Document %d – %s', 'jam' ), $i + 1, $name ) ); ?>
            </a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php endif; ?>

</div>
