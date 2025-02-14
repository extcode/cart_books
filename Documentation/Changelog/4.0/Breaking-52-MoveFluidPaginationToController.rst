.. include:: ../../Includes.rst.txt

===================================================
Breaking: #52 - Move Fluid Pagination to Controller
===================================================

See :issue:`52`

Description
===========

In TYPO3 v11 <f:paginate> has been removed and is implemented via the
controller.

Affected Installations
======================

All installations are affected by this change.

Migration
=========

If the templates for the lists of books in the frontend has been
overwritten, then these templates must also be adapted. If pagination is not
desired, a custom template must be used for the book list.

.. index:: Template, Frontend
