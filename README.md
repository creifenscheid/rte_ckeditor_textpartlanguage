# TYPO3 Extension `rte_ckeditor_textpartlanguage`

## Purpose

This extension integrates the [CKEditor 5 text part language feature](https://ckeditor.com/docs/ckeditor5/latest/api/language.html) into TYPO3’s CKEditor 5.

## Usage

1. Import the plugin in your RTE configuration.

```
editor:
  config:
    importModules:
      - '@creifenscheid/rte-ckeditor-textpartlanguage/plugin.js'
```

2. Add the plugin to your toolbar

```
editor:
  config:
    toolbar:
      items:
      - ...
      - TextPartLanguage
      - ...
```

3. Configure the languages you need
```
editor:
  config:
    language:
      textPartLanguage:
        # EXAMPLE - {title: 'arabic', languageCode: 'ar', textDirection: 'rtl'}
        - { title: 'english', languageCode: 'en' }
```


## Installation

Install this extension via `composer req creifenscheid/rte-ckeditor-textpartlanguage` or download it from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/rte_ckeditor_textpartlanguage/). Then, activate the extension in the Extension Manager of your TYPO3 installation.

### Support
I don't want your money or anything else.
I am doing this for fun, with heart and to improve my coding skills.
Constructive critisism is very welcome.
If you want to contribute, feel free to do so.
Thank you!
