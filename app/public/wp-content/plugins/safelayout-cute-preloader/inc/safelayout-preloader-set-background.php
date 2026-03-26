<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! function_exists( 'safelayout_preloader_set_background' ) ) {

	// Return background css
	function safelayout_preloader_set_background( $options ) {
		?>
		.sl-pl-back {
			pointer-events: auto;
			position: fixed;
			transition: all 0.5s cubic-bezier(0.645, 0.045, 0.355, 1) 0s;
		}
		<?php
		switch ( $options ) {
			case 'fade':
				?>
				.sl-pl-back-fade {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-fade {
					opacity: 0 !important;
				}
				<?php
				break;
			case 'to-left':
				?>
				.sl-pl-back-to-left {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-to-left {
					transform: translateX(-101vw);
					-webkit-transform: translateX(-101vw);
				}
				<?php
				break;
			case 'to-right':
				?>
				.sl-pl-back-to-right {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-to-right {
					transform: translateX(101vw);
					-webkit-transform: translateX(101vw);
				}
				<?php
				break;
			case 'to-top':
				?>
				.sl-pl-back-to-top {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-to-top {
					transform: translateY(-101vh);
					-webkit-transform: translateY(-101vh);
				}
				<?php
				break;
			case 'to-bottom':
				?>
				.sl-pl-back-to-bottom {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-to-bottom {
					transform: translateY(101vh);
					-webkit-transform: translateY(101vh);
				}
				<?php
				break;
			case 'ellipse-bottom':
				?>
				.sl-pl-back-ellipse-bottom {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-ellipse-bottom {
					clip-path: ellipse(150% 150% at 100% 100%);
					-webkit-clip-path: ellipse(150% 150% at 100% 100%);
				}
				.sl-pl-loaded .sl-pl-back-ellipse-bottom {
					clip-path: ellipse(0 0 at 100% 100%);
					-webkit-clip-path: ellipse(0 0 at 100% 100%);
				}
				<?php
				break;
			case 'ellipse-top':
				?>
				.sl-pl-back-ellipse-top {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-ellipse-top {
					clip-path: ellipse(150% 150% at 0 0);
					-webkit-clip-path: ellipse(150% 150% at 0 0);
				}
				.sl-pl-loaded .sl-pl-back-ellipse-top {
					clip-path: ellipse(0 0 at 0 0);
					-webkit-clip-path: ellipse(0 0 at 0 0);
				}
				<?php
				break;
			case 'ellipse-left':
				?>
				.sl-pl-back-ellipse-left {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-ellipse-left {
					clip-path: ellipse(150% 150% at 0 100%);
					-webkit-clip-path: ellipse(150% 150% at 0 100%);
				}
				.sl-pl-loaded .sl-pl-back-ellipse-left {
					clip-path: ellipse(0 0 at 0 100%);
					-webkit-clip-path: ellipse(0 0 at 0 100%);
				}
				<?php
				break;
			case 'ellipse-right':
				?>
				.sl-pl-back-ellipse-right {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-ellipse-right {
					clip-path: ellipse(150% 150% at 100% 0);
					-webkit-clip-path: ellipse(150% 150% at 100% 0);
				}
				.sl-pl-loaded .sl-pl-back-ellipse-right {
					clip-path: ellipse(0 0 at 100% 0);
					-webkit-clip-path: ellipse(0 0 at 100% 0);
				}
				<?php
				break;
			case 'rect':
				?>
				.sl-pl-back-rect {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-rect {
					transform: scale(0);
					-webkit-transform: scale(0);
				}
				<?php
				break;
			case 'diamond':
				?>
				.sl-pl-back-diamond {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-diamond {
					clip-path: polygon(-50% 50%, 50% -50%, 150% 50%, 50% 150%);
					-webkit-clip-path: polygon(-50% 50%, 50% -50%, 150% 50%, 50% 150%);
				}
				.sl-pl-loaded .sl-pl-back-diamond {
					clip-path: polygon(50% 50%, 50% 50%, 50% 50%, 50% 50%);
					-webkit-clip-path: polygon(50% 50%, 50% 50%, 50% 50%, 50% 50%);
				}
				<?php
				break;
			case 'circle':
				?>
				.sl-pl-back-circle {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				.sl-pl-back-circle {
					clip-path: circle(75%);
					-webkit-clip-path: circle(75%);
				}
				.sl-pl-loaded .sl-pl-back-circle {
					clip-path: circle(0);
					-webkit-clip-path: circle(0);
				}
				<?php
				break;
			case 'tear-vertical':
				?>
				#sl-preloader .sl-pl-back-tear-vertical-left {
					background-size: 3200px 1800px, 200% 100%  !important;
					height: 100%;
					left: 0;
					top: 0;
					width: 50%;
				}
				#sl-preloader .sl-pl-back-tear-vertical-right {
					background-position-x: -100%  !important;
					background-size: 3200px 1800px, 200% 100%  !important;
					height: 100%;
					left: 50%;
					top: 0;
					width: 50%;
				}
				.sl-pl-loaded .sl-pl-back-tear-vertical-left {
					transform: translateY(-101vh);
					-webkit-transform: translateY(-101vh);
				}
				.sl-pl-loaded .sl-pl-back-tear-vertical-right {
					transform: translateY(101vh);
					-webkit-transform: translateY(101vh);
				}
				<?php
				break;
			case 'split-horizontal':
				?>
				#sl-preloader .sl-pl-back-split-horizontal-left {
					background-size: 3200px 1800px, 200% 100%  !important;
					height: 100%;
					left: 0;
					top: 0;
					width: 50%;
				}
				#sl-preloader .sl-pl-back-split-horizontal-right {
					background-position-x: -100%  !important;
					background-size: 3200px 1800px, 200% 100%  !important;
					height: 100%;
					left: 50%;
					top: 0;
					width: 50%;
				}
				.sl-pl-loaded .sl-pl-back-split-horizontal-left {
					transform: translateX(-51vw);
					-webkit-transform: translateX(-51vw);
				}
				.sl-pl-loaded .sl-pl-back-split-horizontal-right {
					transform: translateX(51vw);
					-webkit-transform: translateX(51vw);
				}
				<?php
				break;
			case 'tear-horizontal':
				?>
				#sl-preloader .sl-pl-back-tear-horizontal-top {
					background-size: 3200px 1800px, 100% 200%  !important;
					height: 50%;
					left: 0;
					top: 0;
					width: 100%;
				}
				#sl-preloader .sl-pl-back-tear-horizontal-bottom {
					background-position-y: -100%  !important;
					background-size: 3200px 1800px, 100% 200%  !important;
					height: 50%;
					left: 0;
					top: 50%;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-tear-horizontal-top {
					transform: translateX(-101vw);
					-webkit-transform: translateX(-101vw);
				}
				.sl-pl-loaded .sl-pl-back-tear-horizontal-bottom {
					transform: translateX(101vw);
					-webkit-transform: translateX(101vw);
				}
				<?php
				break;
			case 'split-vertical':
				?>
				#sl-preloader .sl-pl-back-split-vertical-top {
					background-size: 3200px 1800px, 100% 200%  !important;
					height: 50%;
					left: 0;
					top: 0;
					width: 100%;
				}
				#sl-preloader .sl-pl-back-split-vertical-bottom {
					background-position-y: -100%  !important;
					background-size: 3200px 1800px, 100% 200%  !important;
					height: 50%;
					left: 0;
					top: 50%;
					width: 100%;
				}
				.sl-pl-loaded .sl-pl-back-split-vertical-top {
					transform: translateY(-51vh);
					-webkit-transform: translateY(-51vh);
				}
				.sl-pl-loaded .sl-pl-back-split-vertical-bottom {
					transform: translateY(51vh);
					-webkit-transform: translateY(51vh);
				}
				<?php
				break;
			case 'linear-left':
				?>
				.sl-pl-back-linear-left {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				#sl-preloader .sl-pl-back-linear-left div {
					background-size: 3200px 1800px, 1000% 100% !important;
					display: inline-block;
					height: 100%;
					transition: all 0.3s cubic-bezier(0.645, 0.045, 0.355, 1) 0s, background 0s;
					width: 10%;
				}
				.sl-pl-loaded .sl-pl-back-linear-left div {
					opacity: 0 !important;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(2) {
					background-position-x: -100% !important;
					transition-delay: 0.025s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(3) {
					background-position-x: -200% !important;
					transition-delay: 0.05s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(4) {
					background-position-x: -300% !important;
					transition-delay: 0.075s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(5) {
					background-position-x: -400% !important;
					transition-delay: 0.1s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(6) {
					background-position-x: -500% !important;
					transition-delay: 0.125s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(7) {
					background-position-x: -600% !important;
					transition-delay: 0.15s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(8) {
					background-position-x: -700% !important;
					transition-delay: 0.175s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(9) {
					background-position-x: -800% !important;
					transition-delay: 0.2s;
				}
				#sl-preloader .sl-pl-back-linear-left div:nth-child(10) {
					background-position-x: -900% !important;
					transition-delay: 0.225s;
				}
				<?php
				break;
			case 'linear-right':
				?>
				.sl-pl-back-linear-right {
					height: 100%;
					left: 0;
					top: 0;
					width: 100%;
				}
				#sl-preloader .sl-pl-back-linear-right div {
					background-size: 3200px 1800px, 1000% 100% !important;
					display: inline-block;
					height: 100%;
					transition: all 0.3s cubic-bezier(0.645, 0.045, 0.355, 1) 0s, background 0s;
					width: 10%;
				}
				.sl-pl-loaded .sl-pl-back-linear-right div {
					opacity: 0 !important;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(10) {
					background-position-x: -900% !important;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(9) {
					background-position-x: -800% !important;
					transition-delay: 0.025s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(8) {
					background-position-x: -700% !important;
					transition-delay: 0.05s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(7) {
					background-position-x: -600% !important;
					transition-delay: 0.075s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(6) {
					background-position-x: -500% !important;
					transition-delay: 0.1s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(5) {
					background-position-x: -400% !important;
					transition-delay: 0.125s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(4) {
					background-position-x: -300% !important;
					transition-delay: 0.15s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(3) {
					background-position-x: -200% !important;
					transition-delay: 0.175s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(2) {
					background-position-x: -100% !important;
					transition-delay: 0.2s;
				}
				#sl-preloader .sl-pl-back-linear-right div:nth-child(1) {
					transition-delay: 0.225s;
				}
				<?php
				break;
		}//end of switch
	}
}