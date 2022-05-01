<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CRUDAdminService;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CRUDAdminController extends Controller
{

    /** @var int */
    public const LIMIT = 100;

    protected CRUDAdminService|null $service = null;

    protected $indexCheckbox = false;
    protected $tempPath = '/uploads/images';

    protected $title = '';
    protected $titlePage = [
//        'index' => '',
//        'create' => '',
//        'edit' => '',
//        'confirm' => '',
//        'show' => '',
    ];

    protected $routeList = [
        'index' => '',
        'create' => '',
        'edit' => '',
        'confirm' => '',
        'complete' => '',
        'show' => '',
        'delete' => '',
        'deleteAll' => '',
    ];

    protected $viewList = [
        'index' => '',
        'create' => '',
        'edit' => '',
        'show' => '',
    ];

    protected $breadcrumbList = [
//        'index' => [
//            'text' => route('route.name'),
//            'text' => route('route.name'),
//        ],
    ];

    /*
     * index -table
     */
    protected $indexTableList = [
//        'id' => [
//            'label' => 'ID',
//            'sort' => true,
//            // type date
//            'type' => 'date',
//            'format' => 'Y年m月d日',
//            // type button
//            'button' => [
//                ['label' => '表示', 'action' => 'show', 'class' => ''],
//                ['label' => '編集', 'action' => 'edit', 'class' => ''],
//                ['label' => '削除', 'action' => 'destroy', 'class' => 'btn-danger', 'exclude' => []],
//            ],
//            // type checkbox , select , radio
//            'type' => 'checkbox',
//            'type' => 'select',
//            'type' => 'radio',
//            'values' => [1 => 'label 1', 2 => 'label 2'],
//
//            // type number
//            'type' => 'number',
//
//            // type render
//            'render' => 'example'
//            // default type = text
//        // add prefix or suffix to value
//        'prefix' => '¥',
//        'suffix' => '¥',
//
//          // display relate value => user.id
//          'relate' => 'user',
//          'attribute_name' => 'id_name', => display user.id_name or without relate , it display table.id_name attr
//        ],
    ];

    /*
     * index - form search
     */
    protected $indexSearchList = [
//        'id' => [
//            'label' => 'ID',
//            'grid_size' => 3,
//
//            // type like => search where like
//            'type' => 'like',
//
//            // type dateFrom => search where id >= date picker value
//            'type' => 'dateFrom',
//
//            // type dateTo => search where id <= date picker value
//            'type' => 'dateTo',
//
//            // type dateFromTo => search where id <= date picker from value and id >= date picker to value
//            'type' => 'dateFromTo',
//
//            // type month => search wehre id = month_picker value
//            'type' => 'month',
//
//            // type checkbox, select, radio => search where id =
//            'type' =>'checkbox',
//            'type' =>'select',
//            'type' =>'radio',
//            'values'=>  [1 => 'label 1', 2 => 'label 2'],
//
//            // default type = text
//            // type search relate table => where user.id =
//            'relate' => 'user'
//
//             //search multi like
//              'type' => 'multi_like',
//              'attribute_name'       => ['first_name', 'last_name'],
//              'multi_like_separator' => ' ',
//        ],
    ];

    /**
     *  create/update - form
     */
    protected $formList = [
//        'id' => [
//            'label' => 'ID',
//            'validation' => ['nullable', 'date'],
//
//            'type' => 'select',
//            'type' => 'select_multi',
//            'type' => 'checkbox',
//            'type' => 'radio',
//            'values' => [1 => 'label 1', 2 => 'label 2'],
//
//            'type' => 'date',
//            'type' => 'datetime',
//            'format' => 'Y-m-d',
//
//            'type' => 'textarea',
//            'type' => 'number',
//            'type'=>'email',
//            'type'=>'password',
//            'type'=>'file',
//            'type'=>'full_name',
//            'type' =>'text',
//
//            // descriptipon small text
//            'help' => 'descriptipon small text'
//        ],
    ];

    /*
     * validate message
     */
    protected $customMessages = [];

    protected $message = [
        'success' => [
            'create' => '成功',
            'update' => '成功'
        ],
    ];

    protected ?FileService $fileService = null;

    public function __construct(CRUDAdminService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        if (request()->get('csv_download') == 1) {
            return $this->csv();
        }

        $items = $this->service
            ->search($this->getSearchCondition(), $this->getIndexSearchList(), $this->getIndexTableList())
            ->paginate(request()->get('limit', static::LIMIT));

        return view(!empty($this->viewList['index']) ? $this->viewList['index'] : 'admin.crud.index', [
            'title' => $this->title,
            'titlePage' => !empty($this->titlePage['index']) ? $this->titlePage['index'] : $this->title,
            'breadcrumbs' => $this->getBreadcrumbs('index', $item ?? null),
            'items' => $items,
            'routeList' => $this->routeList,
            'searchList' => $this->getIndexSearchList(),
            'tableList' => $this->getIndexTableList(),
            'canSelectAll' => $this->indexCheckbox,
            'canCreate' => true,
        ]);
    }

    public function show($id)
    {
        $item = $this->service->find($id);
        if (!$item) {
            abort(404);
        }

        return view(!empty($this->viewList['show']) ? $this->viewList['show'] : 'admin.crud.show', [
            'title' => $this->title,
            'titlePage' => !empty($this->titlePage['show']) ? $this->titlePage['show'] : $this->title,
            'breadcrumbs' => $this->getBreadcrumbs('show', $item ?? null),
            'item' => $item,
            'routeList' => $this->routeList,
            'formList' => $this->getShowFormList($item),
            'canDelete' => true,
            'canEdit' => true,
        ]);
    }

    public function create()
    {
        return view(!empty($this->viewList['create']) ? $this->viewList['create'] : 'admin.crud.create', [
            'title' => $this->title,
            'titlePage' => !empty($this->titlePage['create']) ? $this->titlePage['create'] : $this->title,
            'breadcrumbs' => $this->getBreadcrumbs('create', $item ?? null),
            'item' => null,
            'routeList' => $this->routeList,
            'formList' => $this->getFormList(),
        ]);
    }

    public function edit($id)
    {
        $item = $this->service->find($id);
        if (!$item) {
            abort(404);
        }

        return view(!empty($this->viewList['edit']) ? $this->viewList['edit'] : 'admin.crud.edit', [
            'title' => $this->title,
            'titlePage' => !empty($this->titlePage['edit']) ? $this->titlePage['edit'] : $this->title,
            'breadcrumbs' => $this->getBreadcrumbs('edit', $item ?? null),
            'item' => $item,
            'routeList' => $this->routeList,
            'formList' => $this->getFormList($item),
        ]);
    }

    public function confirm($id = null)
    {
        if (strlen(request()->post('form_back')) > 0) {
            return $this->getBackPage($id);
        }

        if ($id) {
            $item = $this->service->find($id);
            if (!$item) {
                abort(404);
            }
        }

        $validator = $this->validateForm(request()->all(), $item ?? null);
        if ($validator->fails()) {
            return $this->getBackErrorPage($validator, $id);
        }

        $formList = $this->getFormList($item ?? null);

        // save temp file
        foreach ($formList as $formkey => $form) {
            if (($form['type'] ?? '') != 'file') {
                continue;
            }
            $tempFile = request()->file($formkey, null);
            if (!$tempFile) {
                continue;
            }
            // save temp file
            $mimeType = $tempFile->getMimeType();
            $tempFilePath = $this->getFileService()->uploadTempFile($tempFile);
            request()->merge([
                    $formkey . '_file' => [
                        'mime_type' => $mimeType,
                        'path' => $tempFilePath['path'],
                        'file_name' => $tempFile->getClientOriginalName(),
                        'preview_url' => $tempFilePath['url'],
                    ],
                    $formkey => $tempFilePath['url']
                ]
            );
        }

        return view(!empty($this->viewList['confirm']) ? $this->viewList['confirm'] : 'admin.crud.confirm', [
            'title' => $this->title,
            'titlePage' => $id ? (!empty($this->titlePage['edit']) ? $this->titlePage['edit'] : $this->title) : (!empty($this->titlePage['create']) ? $this->titlePage['create'] : $this->title),
            'breadcrumbs' => $this->getBreadcrumbs('confirm', $item ?? null),
            'item' => $item ?? null,
            'routeList' => $this->routeList,
            'formList' => $formList,
        ]);
    }

    public function complete($id = null)
    {

        if (strlen(request()->post('form_back')) > 0) {
            return $this->getBackErrorPage(null, $id);
        }

        if ($id) {
            $item = $this->service->find($id);
            if (!$item) {
                abort(404);
            }
        }

        $formList = $this->getFormList($item ?? null);
        // move temp file to public
        foreach ($formList as $formkey => $form) {
            if (($form['type'] ?? '') != 'file') {
                continue;
            }
            $tempFile = request()->get($formkey . '_file', null);
            $fileService = $this->getFileService();
            if (!$tempFile) {
                request()->request->remove($formkey);
                continue;
            }
            if ($fileService->exist($tempFile) || str_contains($tempFile, $fileService::TEMP_FOLDER)) {
                // no validate file
                unset($this->formList[$formkey]['validation']);
                // move file
                $this->getFileService()->moveTempFile($tempFile, $this->tempPath);
                $newName = str_replace($fileService::TEMP_FOLDER, $this->tempPath, request()->get($formkey));
                request()->merge([$formkey => $newName]);
            }
        }

        $validator = $this->validateForm(request()->all(), $item ?? null);
        if ($validator->fails()) {
            return $this->getBackErrorPage($validator, $id);
        }

        $formValue = $validator->validated();

        // todo: check transaction error and redirect back to page form
        if ($id) {
            $item = $this->service->update($id, $formValue);
            if (!$item) {
                return $this->getBackErrorPage(null, $id);
            }
            $data = $this->afterUpdate($item);
        } else {
            $item = $this->service->create($formValue);
            if (!$item) {
                return $this->getBackErrorPage(null, null);
            }
            $data = $this->afterCreate($item);
        }
        // todo: flash message complete or error
        return $this->getCompletePage($data);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return $this->getCompletePage();
    }

    public function deleteAll()
    {
        // todo not implement
    }

    public function csv()
    {
        $headers = [
            'Content-Type' => 'application/octet-stream',
        ];

        $fileName = str_replace('/', '_', request()->path())
            . '_' . date('Ymd_His')
            . '.csv';

        $controller = $this;
        return response()->streamDownload(function () use ($controller) {
            $controller->csvStream();
        }, $fileName, $headers);
    }

    public function csvStream()
    {
        $stream = fopen('php://output', 'w');

        stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

        $columns = $this->service->csvColumn();

        fputcsv($stream, $columns);

        $query = $this->service->search($this->getSearchCondition(), $this->indexSearchList);

        foreach ($query->cursor() as $row) {
            $values = [];
            foreach ($row->toArray() as $value) {
                if (!is_array($value)) {
                    $values[] = $value;
                }
            }

            fputcsv($stream, $values);
        }
        fclose($stream);
    }

    protected function getBackPage($id = null)
    {
        if ($id) {
            $redirect = redirect()->route($this->routeList['show'], $id);
        } else {
            $redirect = redirect()->route($this->routeList['index']);
        }
        return $redirect->withInput();
    }

    protected function getBackErrorPage($validator = null, $id = null)
    {
        if ($id) {
            $redirect = redirect()->route($this->routeList['edit'], $id);
        } else {
            $redirect = redirect()->route($this->routeList['create']);
        }

        if ($validator) {
            $redirect = $redirect->withErrors($validator);
        }

        return $redirect->withInput();
    }

    protected function getCompletePage($data = null)
    {
        if (!is_null($data) && !empty($this->message['success'])) {
            if ($data['status'] == 'create') {
                return redirect()->route($this->routeList['index'])->with('success', $this->message['success']['create']);
            } else if ($data['status'] == 'update') {
                return redirect()->route($this->routeList['index'])->with('success', $this->message['success']['update']);
            }
        }
        return redirect()->route($this->routeList['index']);
    }

    protected function getSearchCondition(): array
    {
        return request()->all();
    }

    protected function getIndexTableList()
    {
        return $this->indexTableList;
    }

    protected function getIndexSearchList()
    {
        return $this->indexSearchList;
    }

    protected function getFormList(?Model $item = null)
    {
        // form for create/edit
        return $this->formList;
    }

    protected function getShowFormList(Model $item)
    {
        // form for show/detail page
        return $this->getFormList($item);
    }

    protected function validateForm($data, $model = null)
    {
        $rules = [];
        $customAttributes = [];

        foreach ($this->getFormList($model) as $key => $item) {
            $tempRules = [];
            if (isset($item['validation'])) {
                $tempRules = array_merge($tempRules, $item['validation']);
            } else {
                $tempRules = array_merge($tempRules, ['nullable']);
            }

            switch ($item['type'] ?? '') {
                case 'full_name':
                    $rules['first_' . $key] = $tempRules;
                    $customAttributes['first_' . $key] = '姓';
                    $rules['last_' . $key] = $tempRules;
                    $customAttributes['last_' . $key] = '名';
                    unset($rules[$key], $customAttributes[$key]);
                    break;
                default:
                    $rules[$key] = $tempRules;
                    $customAttributes[$key] = $item['label'];
                    break;
            }

            if (!empty($item['custom_message'])) {
                $this->customMessages = array_merge($this->customMessages, $item['custom_message']);
            }
        }

        $rules = $this->getAdditionalValidationRules($rules, $data, $model);

        $validator = Validator::make($data, $rules, $this->customMessages, $customAttributes);

        return $validator;
    }

    protected function getAdditionalValidationRules($rules, $data, $model)
    {
        return $rules;
    }

    protected function getBreadcrumbs($action, ?Model $item = null): array
    {
        $breadcrumbs = [];

        if (!empty($this->breadcrumbList[$action]) && is_array($this->breadcrumbList[$action])) {
            $breadcrumbs = $this->breadcrumbList[$action];
        } else {
            // default breadcrumbs
            $breadcrumbs = [
                'Home' => route('admin.dashboard'),
            ];
            if (!empty($this->routeList['index'])) {
                $breadcrumbs[$this->titlePage['index'] ?? 'index'] = route($this->routeList['index']);
            }
            switch ($action) {
                case 'show':
                    if (!empty($this->routeList['show'])) {
                        $breadcrumbs[$item->id] = route($this->routeList['show'], $item->id);
                    }
                    break;
                case 'create':
                    $breadcrumbs['追加'] = null;
                    break;
                case 'edit':
                    if (!empty($this->routeList['show'])) {
                        $breadcrumbs[$item->id] = route($this->routeList['show'], $item->id);
                    }
                    $breadcrumbs['編集'] = null;
                    break;
                case 'confirm':
                    if ($item) {
                        if (!empty($this->routeList['show'])) {
                            $breadcrumbs[$item->id] = route($this->routeList['show'], $item->id);
                        }
                        $breadcrumbs['編集'] = null;
                    } else {
                        $breadcrumbs['追加'] = null;
                    }
                    break;
                default:
                    break;
            }
        }

        return $breadcrumbs;
    }

    protected function afterCreate(Model $item)
    {
        return [
            'item' => $item,
            'status' => 'create'
        ];
    }

    protected function afterUpdate(Model $item)
    {
        return [
            'item' => $item,
            'status' => 'update'
        ];
    }

    protected function getFileService()
    {
        if (!$this->fileService) {
            $this->fileService = app()->make(FileService::class);
        }

        return $this->fileService;
    }

}
