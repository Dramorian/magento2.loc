<?php

namespace Alex\AskQuestion\Ui\Component\Listing\Column;

use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class prepare Page Actions
 */
class QuestionActions extends Column
{
    /** Url path */
    private const URL_PATH_EDIT = 'askquestion/question/edit';
    private const URL_PATH_DELETE = 'askquestion/question/delete';

    /**
     * @var UrlBuilder
     */
    protected UrlBuilder $actionUrlBuilder;

    /**
     * @var \Magento\Cms\ViewModel\Page\Grid\UrlBuilder
     */
    private $scopeUrlBuilder;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var string
     */
    private string $editUrl;

    /**
     * @var Escaper
     */
    private Escaper $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        Escaper            $escaper,
        array              $components = [],
        array              $data = [],
        string             $editUrl = self::URL_PATH_EDIT,
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['question_id'])) {
//                    $item[$name]['edit'] = [
//                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['question_id' => $item['question_id']]),
//                        'label' => __('Edit'),
//                    ];
                    $title = $this->escaper->escapeHtml($item['name']);
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_DELETE,
                            ['question_id' => $item['question_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
                if (isset($item['identifier'])) {
                    $item[$name]['preview'] = [
                        'href' => $this->scopeUrlBuilder->getUrl(
                            $item['identifier'],
                            $item['_first_store_id'] ?? null,
                            $item['store_code'] ?? null
                        ),
                        'label' => __('View'),
                        'target' => '_blank'
                    ];
                }
            }
        }

        return $dataSource;
    }
}
