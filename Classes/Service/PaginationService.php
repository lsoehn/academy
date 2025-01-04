<?php

/***************************************************************
 *  Copyright notice
 *
 *  Copyright (C) 2011-2025 Academy of Sciences and Literature | Mainz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace Digicademy\Academy\Service;

use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;

/**
 * This service implements a sliding window pagination for CRIS entities
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 */

class PaginationService
{
    /**
     * Generates pagination data for the given QueryResult
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $queryResult
     * @param int $currentPage
     * @param int $itemsPerPage
     * @param int $maximumPages
     * @return array
     */
    public function paginate(
        \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $queryResult,
        int $currentPage = 1,
        int $itemsPerPage = 10,
        int $maximumPages = 10
    ): array {
        // Initialize Paginator
        $queryResultPaginator = new QueryResultPaginator(
            $queryResult,
            $currentPage,
            $itemsPerPage
        );

        // Initialize Sliding Window Pagination
        $slidingWindowPagination = new SlidingWindowPagination(
            $queryResultPaginator,
            $maximumPages
        );

        // Generate pagination data
        return [
            'currentPage' => $currentPage,
            'totalPages' => $queryResultPaginator->getNumberOfPages(),
            'maximumPagesPerStep' => $maximumPages,
            'itemsPerPage' => $itemsPerPage,
            'totalItems' => $queryResult->count(),
            'firstPage' => $slidingWindowPagination->getFirstPageNumber(),
            'hasPreviousPage' => $slidingWindowPagination->getHasLessPages(),
            'previousPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'hasNextPage' => $slidingWindowPagination->getHasMorePages(),
            'nextPage' => $currentPage < $queryResultPaginator->getNumberOfPages() ? $currentPage + 1 : null,
            'lastPage' => $slidingWindowPagination->getLastPageNumber(),
            'pages' => $slidingWindowPagination->getAllPageNumbers(),
            'paginatedItems' => $queryResultPaginator->getPaginatedItems()
        ];
    }
}
