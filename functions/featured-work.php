<?php

/**
 * Homepage "Featured Work" carousel.
 *
 * The carousel rotates one ordered list that mixes `projects` and `service`
 * posts (ACF field `featured_projects` on templates/new-home.php). The two post
 * types store their card content under different fields, so the card model
 * below normalizes them into a single shape and
 * templates/new-home/featured-projects.php renders one markup block for both.
 */


/**
 * Normalize a project or service post into the carousel's card model.
 *
 * @param int $post_id
 * @return array {
 *     @type int|null    $image_id  Lead image attachment ID.
 *     @type string      $title     Headline text.
 *     @type string      $permalink Link target for the lead image and headline.
 *     @type array|null  $eyebrow   Teal label above the headline, as
 *                                  ['text' => string, 'url' => string|null].
 *                                  A null url renders the label unlinked.
 *     @type string      $meta      Gray line under the headline. Projects only.
 *     @type string      $copy      Body of the white description box.
 * }
 */
function esa_featured_work_card( $post_id ) {

	// Projects and services both store the lead image as `hero` > `photo`,
	// which ACF flattens to the same `hero_photo` key on either post type.
	$image = get_field( 'hero_photo', $post_id );

	$card = array(
		'image_id'  => isset( $image['ID'] ) ? $image['ID'] : null,
		'title'     => get_the_title( $post_id ),
		'permalink' => get_permalink( $post_id ),
		'eyebrow'   => null,
		'meta'      => '',
		'copy'      => '',
	);

	if ( get_post_type( $post_id ) === 'service' ) {

		// Services carry no market and no location. The eyebrow names the card
		// type instead of its topic, and the meta line is left off entirely.
		$card['eyebrow'] = array(
			'text' => 'Services',
			'url'  => null,
		);

		$card['copy'] = esa_featured_work_description( $post_id );

		return $card;
	}

	$market = get_field( 'details_market', $post_id );

	$card['meta'] = get_field( 'details_location', $post_id );
	$card['copy'] = get_field( 'details_about', $post_id );

	if ( $market ) {
		$card['eyebrow'] = array(
			'text' => get_the_title( $market ),
			'url'  => get_permalink( $market ),
		);
	}

	return $card;
}


/**
 * Resolve the description shown in a service card's white box.
 *
 * Service pages run on several different templates, each with its own field
 * group, so there is no single description field across the post type:
 *
 *   templates/emerging-technology.php  `overview` > `lede`   (wysiwyg, 1-2 sentences)
 *   default single-service             `about` > `copy`      (wysiwyg, full page body)
 *   templates/platform-detail.php      its own field group
 *   templates/platforms.php            its own field group
 *
 * Only the emerging-technology lede is written at card length. The others are
 * page-length bodies that would overflow the box, so they need a policy.
 *
 * @param int $post_id
 * @return string Card-length description, or '' to render the card without one.
 */
function esa_featured_work_description( $post_id ) {

	// The emerging-technology lede is already card-length copy — the AI &
	// Emerging Technologies page is the current source of truth for this shape.
	$overview = get_field( 'overview', $post_id );

	if ( ! empty( $overview['lede'] ) ) {
		return $overview['lede'];
	}

	// TODO(andy): decide the fallback for services on the other templates.
	//
	// `about` > `copy` is the obvious next source but it is a full page body,
	// often several paragraphs. Options, roughly in order of effort:
	//
	//   1. Return '' — only services with a card-length lede get a description.
	//      Keeps the carousel tight; other services show image + title only.
	//   2. Truncate `about` > `copy` — e.g.
	//      wp_trim_words( wp_strip_all_tags( $about['copy'] ), 40 ).
	//      Works everywhere but the cut can land mid-thought.
	//   3. Fall back to the post excerpt, so an editor writes the card copy
	//      deliberately. Most control, but needs excerpts filled in per service.
	//
	// Option 1 is the current behavior.
	return '';
}
