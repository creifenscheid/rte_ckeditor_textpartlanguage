## TYPO3 Extension `cke_textpartlanguage`

## Purpose

This extension integrates the [CKEditor 5 text part language feature](https://ckeditor.com/docs/ckeditor5/latest/api/language.html) text part language feature into TYPO3’s CKEditor 5.

## Usage

### Plugin import

You can import the provided plugin configuration in your RTE configuration.

```
imports:
  - { resource: "EXT:cke_textpartlanguage/Configuration/RTE/Plugin.yaml" }
```

### RTE preset

You can use the Page TSconfig file `EXT:CkeTextpartlanguage :: Use RTE preset` to apply the provided RTE preset (as default preset and for tt_content.bodytext)

Simply add the file in your root page properties.

### Custom configuration

You can configure the plugin in your RTE configuration file. 

#### Example configuration

```
editor:
  config:
    importModules:
      - '@creifenscheid/cke-textpartlanguage/plugin.js'

    toolbar:
      items:
        - textPartLanguage
    language:
      textPartLanguage:
        # EXAMPLE - {title: 'arabic', languageCode: 'ar', textDirection: 'rtl'}
        - { title: 'english', languageCode: 'en' }
```


## Installation

Install this extension via `composer req creifenscheid/cke-textpartlanguage` or download it from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/cke_textpartlanguage/). Then, activate the extension in the Extension Manager of your TYPO3 installation.

### Support
I don't want your money or anything else.
I am doing this for fun, with heart and to improve my coding skills.
Constructive critisism is very welcome.
If you want to contribute, feel free to do so.
Thank you!
