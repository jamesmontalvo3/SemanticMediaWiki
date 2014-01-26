<?php

namespace SMW\Test;

use Title;
use UnexpectedValueException;

/**
 * @ingroup Test
 *
 * @group SMW
 * @group SMWExtension
 *
 * @licence GNU GPL v2+
 * @since 1.9.0.3
 */
class PageCreator {

	/** @var WikiPage */
	protected $page = null;

	/**
	 * @since 1.9.0.3
	 *
	 * @return WikiPage
	 * @throws UnexpectedValueException
	 */
	public function getPage() {

		if ( $this->page instanceof \WikiPage ) {
			return $this->page;
		}

		throw new UnexpectedValueException( 'Expected a WikiPage instance, use createPage first' );
	}

	/**
	 * @since 1.9.0.3
	 *
	 * @return PageCreator
	 */
	public function createPage( Title $title, $editContent = '' ) {

		$this->page = new \WikiPage( $title );

		$pageContent = 'Content of ' . $title->getFullText() . ' ' . $editContent;
		$editMessage = 'SMW system test: create page';

		return $this->doEdit( $pageContent, $editMessage );
	}

	/**
	 * @since 1.9.0.3
	 *
	 * @return PageCreator
	 */
	public function doEdit( $pageContent = '', $editMessage = '' ) {

		if ( class_exists( 'WikitextContent' ) ) {
			$content = new \WikitextContent( $pageContent );

			$this->getPage()->doEditContent(
				$content,
				$editMessage
			);

		} else {
			$this->getPage()->doEdit( $pageContent, $editMessage );
		}

		return $this;
	}

}

class PageDeleter {

	public function deletePage( Title $title ) {
		$page = new \WikiPage( $title );
		$page->doDeleteArticle( 'SMW system test: delete page' );
	}

}
