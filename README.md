# box-packer-api

Provides a very simple API interface for North American Web's 
[Box Packer package](https://github.com/north-american-web/box-packer).

Currently there's only one endpoint available: /v1/packing_attempt. It only accepts POST requests including box and item
specifications. 

####Requests
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

An example request using Javascript:
~~~~
const API_URL = '<your domain>/v1/packing_attempt'

const boxes = [
    { width: 2, length: 2, height: 2, description: "Box 1" }
]

const items = [
    { width: 1, length: 1.1, height: 1, description: "Item 1" }, 
    { width: 1, length: 1.1, height: 1, description: "Item 2" },
    { width: 3, length: 1.1, height: 1, description: "Item 1" }
]

fetch(API_URL, {
    method: 'POST',
    mode: 'cors',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        boxes, items
    })
})
.then(response => response.json() )
.then(response => {
    if( response.message){
        throw new Error(response.message)
    }

    return response;
})
~~~~


####Responses
/v1/packing_attempt will return a JSON string representation of an object having to following scheme:

~~~~
{
    success: <bool>
    packed: [
        <container>
    ],
    empty: [
        <container>
    ],
    leftOverItems: [
        <solid>
    ]
}
~~~~

`success`: boolean indicating whether all the items will fit into the given box(es)/container(s)

`packed`: An array of `container` objects

`empty`: An array of `container` objects

`leftOverItems`: An array of `solid` objects

"`solid`" objects (as referenced above) look like this:
~~~~
{
    width: <float>,
    length: <float>,
    height: <float>,
    description: <string>
}
~~~~

"`containers`" (as referenced above) are identical except that they have a `contents` property that holds an array of `solid`s.
~~~~
{
    width: <float>,
    length: <float>,
    height: <float>,
    description: <string>,
    contents: [
        <solid>
    ]
}
~~~~