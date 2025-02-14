.. include:: ../../Includes.rst.txt

============================================
Breaking: #52 - Add Pagination to Controller
============================================

See :issue:`52`

Description
===========

Because in TYPO3 v11 no pagination in the frontend is possible without an own
ViewHelper or an extension, the list action in the BookController was
extended by the pagination. Via TypoScript it can be defined how many books
should be displayed per page.

Integration
===========

An example was implemented in the list action template.

.. index:: Template, Frontend
