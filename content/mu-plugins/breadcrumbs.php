<?php

class Breadcrumbs {
	/**
	 * @param int $objectParentId
	 *
	 * @return array
	 */
	private function getPageBreadcrumbs( $objectParentId ) {
		$objectBreadcrumbs = array();

		while ( $objectParentId ) {
			$objectParent = get_post( $objectParentId );
			$objectBreadcrumbs[] = array(
				'permalink' => get_permalink( $objectParent ),
				'title'     => get_the_title( $objectParent ),
			);
			$objectParentId = $objectParent->post_parent;
		}

		return $objectBreadcrumbs;
	}

	/**
	 * @param int    $objectParentId
	 * @param string $objectTaxonomy
	 *
	 * @return array
	 */
	private function getTaxonomyTermBreadcrumbs( $objectParentId, $objectTaxonomy ) {
		$objectBreadcrumbs = array();

		if ( is_taxonomy_hierarchical( $objectTaxonomy ) ) {
			while ( $objectParentId ) {
				$objectParent = get_term_by( 'id', $objectParentId, $objectTaxonomy );
				$objectBreadcrumbs[] = array(
					'permalink' => get_term_link( $objectParent ),
					'title'     => $objectParent->name,
				);
				$objectParentId = $objectParent->parent;
			}
		}

		return $objectBreadcrumbs;
	}

	/**
	 * @param object $args
	 *
	 * @return array
	 */
	private function generate( $args ) {
		$breadcrumbs = array();

		if ( is_home() || is_front_page() || $args->show_home ) {
			$breadcrumbs[] = array(
				'permalink' => home_url( '/' ),
				'title'     => get_bloginfo( 'name' ),
			);
		}

		$queriedObject = get_queried_object();

		if ( is_page() ) {
			$objectType = 'page';
			$objectBreadcrumbs = $this->getPageBreadcrumbs( $queriedObject->post_parent );

			$breadcrumbs = array_merge( $breadcrumbs, array_reverse( $objectBreadcrumbs ) );
			$breadcrumbs[] = array(
				'permalink' => get_permalink( $queriedObject ),
				'title'     => get_the_title( $queriedObject ),
			);
		} elseif ( is_single() ) {
			$objectType = 'single';

			if ( $args->show_single_tax ) {
				$objectTaxonomies = get_object_taxonomies( get_post_type( $queriedObject ), 'objects' );

				foreach ( $objectTaxonomies as $objectTaxonomy ) {
					if ( $objectTaxonomy->hierarchical ) {
						$objectTerms = wp_get_object_terms( $queriedObject->ID, $objectTaxonomy->name );

						if ( !empty( $objectTerms ) ) {
							$objectTerm = reset( $objectTerms );
							$objectBreadcrumbs = $this->getTaxonomyTermBreadcrumbs( $objectTerm->parent, $objectTaxonomy->name );

							$breadcrumbs = array_merge( $breadcrumbs, array_reverse( $objectBreadcrumbs ) );
							$breadcrumbs[] = array(
								'permalink' => get_term_link( $objectTerm ),
								'title'     => $objectTerm->name,
							);

							break;
						}
					}
				}
			}

			$breadcrumbs[] = array(
				'permalink' => get_permalink( $queriedObject ),
				'title'     => get_the_title( $queriedObject ),
			);
		} elseif ( is_post_type_archive() ) {
			$objectType = 'post_type_archive';
			$postTypeObject = get_post_type_object( get_query_var( 'post_type' ) );

			if ( $postTypeObject ) {
				$breadcrumbs[] = array(
					'permalink' => get_post_type_archive_link( $postTypeObject->name ),
					'title'     => post_type_archive_title( '', false ),
				);
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$objectType = 'category_tag_tax';
			$objectBreadcrumbs = $this->getTaxonomyTermBreadcrumbs( $queriedObject->parent, $queriedObject->taxonomy );

			$breadcrumbs = array_merge( $breadcrumbs, array_reverse( $objectBreadcrumbs ) );
			$breadcrumbs[] = array(
				'permalink' => get_term_link( $queriedObject ),
				'title'     => $queriedObject->name,
			);
		} elseif ( is_date() ) {
			if ( is_year() || is_month() || is_day() ) {
				$objectType = 'year';
				$breadcrumbs[] = array(
					'permalink' => get_year_link( get_query_var( 'year' ) ),
					'title'     => get_the_date( 'Y' ),
				);
			}

			if ( is_month() || is_day() ) {
				$objectType = 'month';
				$breadcrumbs[] = array(
					'permalink' => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
					'title'     => get_the_date( 'F' ),
				);
			}

			if ( is_day() ) {
				$objectType = 'day';
				$breadcrumbs[] = array(
					'permalink' => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) ),
					'title'     => mb_strtoupper( get_the_date( 'l' ) ),
				);
			}
		} elseif ( is_search() ) {
			$objectType = 'search';
			$breadcrumbs[] = array(
				'permalink' => get_search_link(),
				'title'     => sprintf(
					__( 'Search Results &quot;%1$s&quot;', 'ivn_breadcrumbs' ),
					esc_attr( get_search_query() )
				),
			);
		} elseif ( is_author() ) {
			$objectType = 'author';
			$breadcrumbs[] = array(
				'permalink' => get_author_posts_url( get_query_var( 'author' ) ),
				'title'     => sprintf(
					__( 'Author Archive &quot;%1$s&quot;', 'ivn_breadcrumbs' ),
					$queriedObject->display_name
				),
			);
		} elseif ( is_404() ) {
			$objectType = '404';
			$breadcrumbs[] = array(
				'permalink' => home_url( '/' ),
				'title'     => __( '404 Not Found', 'ivn_breadcrumbs' ),
			);
		}

		return apply_filters( 'ivn_breadcrumbs', $breadcrumbs, isset( $objectType ) ? $objectType : 'other' );
	}

	/**
	 * @param array $args
	 *
	 * @return void
	 */
	public function display( $args = array() ) {
		$args = (object) apply_filters( 'ivn_breadcrumbs_args', wp_parse_args( $args, array(
			'show_home'       => true,
			'show_single_tax' => true,
			'divider'         => '',
			'container_tag'   => 'ul',
			'container_id'    => '',
			'container_class' => '',
			'element_tag'     => 'li',
			'element_class'   => '',
		) ) );

		if ( !$args->container_tag || !$args->element_tag ) {
			return;
		}

		$containerId = !empty( $args->container_id ) ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
		$containerClass = !empty( $args->container_class ) ? ' class="' . esc_attr( $args->container_class ) . '"' : '';
		$display = '<' . $args->container_tag . $containerId . $containerClass . '>';

		if ( $breadcrumbs = $this->generate( $args ) ) {
			$elements = array();

			foreach ( $breadcrumbs as $breadcrumb ) {
				$elementClass = !empty( $args->element_class ) ? ' class="' . esc_attr( $args->element_class ) . '"' : '';
				$elements[] = sprintf(
					'<' . $args->element_tag . $elementClass . '><a href="%s" title="%s">%s</a></' . $args->element_tag . '>',
					esc_url( $breadcrumb['permalink'] ),
					esc_attr( strip_tags( $breadcrumb['title'] ) ),
					esc_html( $breadcrumb['title'] )
				);
			}

			$display .= implode( $args->divider, $elements );
		}

		$display .= '</' . $args->container_tag . '>';

		echo apply_filters( 'ivn_breadcrumbs_display', $display );
	}
}