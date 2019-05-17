# box-packer-api

Provides a very simple API interface for North American Web's 
[Box Packer package](https://github.com/north-american-web/box-packer).

Currently there's only one endpoint available: /v1/packing_attempt. It only accepts POST requests including box and item
specifications. 

Here are the posted data validation rules, for those who speak Lumen (or Laravel).
~~~~
'boxes' => 'required|array',
'boxes.*' => 'required|array',
'boxes.*.width' => 'required|numeric|gt:0',
'boxes.*.length' => 'required|numeric|gt:0',
'boxes.*.height' => 'required|numeric|gt:0',
'boxes.*.description' => 'nullable|between:1,128',
'items' => 'required|array',
'items.*' => 'required|array',
'items.*.width' => 'required|numeric|gt:0',
'items.*.length' => 'required|numeric|gt:0',
'items.*.height' => 'required|numeric|gt:0',
'items.*.description' => 'nullable|between:1,128'
~~~~