<?php
/**
 * MagoArab WhatsApp Icon Extension
 * CMS Pages Source Model
 */

namespace MagoArab\WhatsappIcon\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;

class CmsPages implements ArrayInterface
{
    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        
        try {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('is_active', 1)
                ->create();
            
            $pages = $this->pageRepository->getList($searchCriteria);
            
            foreach ($pages->getItems() as $page) {
                $options[] = [
                    'value' => $page->getId(),
                    'label' => $page->getTitle() . ' (' . $page->getIdentifier() . ')'
                ];
            }
        } catch (LocalizedException $e) {
            // Handle exception silently
        }
        
        return $options;
    }
}