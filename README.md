EcoEngine
=========

"Wordpress like" template setting manager for Croogo. The missing feature from the templating engine in Croogo.

##What is this?##

This plugin adds a new submenu at Extensions/Themes/[Settings] which takes you to a screen where you can manage different options (that YOU, the creator of themes can set up) related to the theme.

You know, like the background image, font size, font type, google analytics code, widths, colors, or upload files (default FileManager and Node plugins required).

##How do i install this plugin?##

- Upload it to /app/Plugin/EcoEngine/
- Activate it in Croogo (Extensions/Plugins)
- Enjoy

##I am a theme developer##

You, Mr/Ms Theme developer are going to create a file that contains all the required information for this plugin to setup all the fields. This file has to be at your theme's webroot, along with your ``theme.json``.. this file should be called ``EcoEngine.json`` 

EcoEngine.json should be formated this way:
````
{
    "Group": {
        "fieldName": {
            "type": "fieldType",
            "explain": "explanation of this field for the user",
            "cakeField": {
                "label": "Background Image",
                "value":""
            }
        },
        "anotherFieldName": {
            "type": "fieldType",
            "cakeField": {
                "options": {
                    "0": "select option",
                    "1": "select option"
                },
                "multiple": 1,
                "label": "Label for the field",
                "value": 0
            },
            "explain": "explanation of this field for the user"
        }
    },
    "Another group": {
        ...
    }
}
````

Example:
````
{
    "Header": {
        "bgImage": {
            "type": "file",
            "explain": "Select an image from your computer",
            "cakeField": {
                "label": "Background Image",
                "value":""
            }
        },
        "mobile": {
            "type": "select",
            "cakeField": {
                "options": {
                    "0": "iOS",
                    "1": "Android"
                },
                "multiple":1,
                "label": "Mobile platform",
                "value": 0
            },
            "explain": "Pick one"
        }
    },
    "Default": {
        "imageAlt": {
            "type": "input",
            "cakeField": {
                "label": "Default Alt",
                "value":""
            },
            "explain": "Enter default alt for images"
        }
    }
}
````

This will create 3 fields in 2 different groups

First group is called Header:
  - First field is called "bgImage"
    - the field is going to be created using the element called "file" (more on this later)
    - the fields explanation is "Select an image from your computer"
    - cakeField is the param array passed directly to $this->Form->input('name', $param) (more on this later)
    - Default value for this option is empty (dont use null, its a croogo settings plugin database limitation)
  - Second field is called "mobile"
    - the field is going to be created using the element called "select" (more on this later)
    - the fields explanation is "Pick one"
    - cakeField contains the options for this input (this should create a select input using $this->Form->input..)
    - multiple selection is allowed
    - default value for this field is option 0

Second group is called Default:
  - First field is called "imageAlt"
    - the field is going to be created using the element called "input" (more on this later)
    - the fields explanation is "Enter default alt for images"
    - cakeField contains the label value for this element which is "Default Alt", and an empty default value

Now the generated fields should look like this (remember, this screen is at Extensions/Themes/Settings):
[Screen](http://ecor.me/static/fieldPreview.png "Screen")

##Which element fields are available for use?##
By default I set up 2 fields:

- File field which has an uploader which currently is able to upload 1 file at the time (everything is there to upload multiple files, i just need to figure out a good UI for it)
- Universal [CakePHP input](http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::input) ($this->Form->input .. ) which is very good because this turns into text boxes, textareas, selects (click the link for more information)

Fields are created using elements named after the "field type" it creates (it can be any name, not just default html field types, this is just for reference)
Also I made it expandable for any custom field you want to setup, just develop it and place it inside your theme folder at /Themed/{yourTheme}/Elements/{yourFieldType}.ctp and you will be able to reference it in your EcoEngine.json

You can override the default elements by using the same name and placing it inside your theme folder (see above for specific path)

##How can it use these values?##

All the values will be available in a View variable called $theme (array) formated this way:
````
$theme
  EcoEngine
    theme => {yourTheme}
    support => (true)
    installed => 1
    file => /home/lasvegas/public_html/app/View/Themed/{yourTheme}/webroot/EcoEngine.json
  Settings
    Header.bgImage => ""
    Header.mobile => 0
    Default.imageAlt => ""
````
##I am ready, how do i start?##

- Setup your EcoEngine.json file
- Upload your theme
- Activate your theme
- Go to: Settings / EcoEngine (menu on the left)
- Check that your theme declares support for EcoEngine, and that it is not installed yet.
- Click install (if something goes wrong during development you can always uninstall all values by clicking "unset all", then you can reinstall)
- Go to: Extensions/Themes/Settings
- Check that all fields are displayed correctly
- Enjoy


##I want to develop new fields / elements##

- Create new element named after the reference you want to use for this field, lets say "color" so you place it in {yourTheme}/Elements/color.ctp
- Check out the provided element to understand whats going on
- The plugin will pass some variables that will be available in your element, these are:
````
$id - The internal pointer to where the field value is saved (ie: 190)
$key - The key where the value is saved (ie: EcoEngine.{yourTheme}.Group.BgColor)
$value - The value saved (ie: #000000)
$field - An array containing the values from your EcoEngine.json for this field

````
- If you are creating a complex element/field, check out the callback section in the default file element to manipulate the data returned in the way you need using Javascript/jQuery
- Save it
- Reference it in your EcoEngine.json file
- Enjoy

##Your plugin takes a lot of my server resources##

Really?, well then you can edit Config/bootstrap.php and unhook the component from every controller and just hook it to this plugin controller.
This way you wont have the $theme variable available everywhere, so you will have to extract the values manually from the database using the "FileManager.Setting" Model (or any method you have available), its not complicated but you are on your own :).
