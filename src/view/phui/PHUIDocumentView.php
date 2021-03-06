<?php

final class PHUIDocumentView extends AphrontTagView {

  private $offset;
  private $header;
  private $sidenav;
  private $topnav;
  private $crumbs;
  private $bookname;
  private $bookdescription;

  public function setOffset($offset) {
    $this->offset = $offset;
    return $this;
  }

  public function setHeader(PhabricatorHeaderView $header) {
    $this->header = $header;
    return $this;
  }

  public function setSideNav(PHUIListView $list) {
    $this->sidenav = $list;
    return $this;
  }

  public function setTopNav(PHUIListView $list) {
    $this->topnav = $list;
    return $this;
  }

  public function setCrumbs(PHUIListView $list) {
    $this->crumbs  = $list;
    return $this;
  }

  public function setBook($name, $description) {
    $this->bookname = $name;
    $this->bookdescription = $description;
    return $this;
  }

  public function getTagAttributes() {
    $classes = array();

    if ($this->offset) {
      $classes[] = 'phui-document-offset';
    };

    return array(
      'class' => $classes,
    );
  }

  public function getTagContent() {
    require_celerity_resource('phui-document-view-css');

    $classes = array();
    $classes[] = 'phui-document-view';
    if ($this->offset) {
      $classes[] = 'phui-offset-view';
    }
    if ($this->sidenav) {
      $classes[] = 'phui-sidenav-view';
    }

    $sidenav = null;
    if ($this->sidenav) {
      $sidenav = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-sidenav'
        ),
        $this->sidenav);
    }

    $book = null;
    if ($this->bookname) {
      $book = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-bookname grouped'
        ),
        array(
          phutil_tag(
            'span',
            array('class' => 'bookname'),
            $this->bookname),
          phutil_tag(
            'span',
            array('class' => 'bookdescription'),
          $this->bookdescription)));
    }

    $topnav = null;
    if ($this->topnav) {
      $topnav = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-topnav'
        ),
        $this->topnav);
    }

    $crumbs = null;
    if ($this->crumbs) {
      $crumbs = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-crumbs'
        ),
        $this->bookName);
    }

    $content_inner = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-inner',
        ),
        array(
          $book,
          $this->header,
          $topnav,
          $this->renderChildren(),
          $crumbs
        ));

    $content = phutil_tag(
        'div',
        array(
          'class' => 'phui-document-content',
        ),
        array(
          $sidenav,
          $content_inner
        ));

    $view = phutil_tag(
      'div',
      array(
        'class' => implode(' ', $classes),
      ),
      $content);

    return $view;
  }

}
