<?php

namespace Ushahidi\Modules\V5\Actions\HXL\Handlers;

use App\Bus\Query\AbstractQueryHandler;
use App\Bus\Query\Query;
use Ushahidi\Modules\V5\Actions\HXL\Queries\FetchHXLQuery;
use Ushahidi\Modules\V5\Repository\HXL\HXLRepository;

class FetchHXLQueryHandler extends AbstractQueryHandler
{
    private $hxl_repository;

    public function __construct(HXLRepository $hxl_repository)
    {
        $this->hxl_repository = $hxl_repository;
    }

    protected function isSupported(Query $query)
    {
        assert(
            get_class($query) === FetchHXLQuery::class,
            'Provided query is not supported'
        );
    }
    
    /**
     * @param FetchHXLQuery $query
     * @return LengthAwarePaginator
     */
    public function __invoke($query) //: LengthAwarePaginator
    {
        $this->isSupported($query);
        return $this->hxl_repository->fetch(
            $query->getPaging(),
            $query->getSearchFields()
        );
    }
}
