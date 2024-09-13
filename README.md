# [OBSOLETE] TYPO3 Extension `rte_ckeditor_textpartlanguage`  

**As of TYPO3 version 12.4.8, the CKEditor 5 plugin provided by this extension is part of the TYPO3 core. Therefore, this extension is superfluous.**

## Core Plugin Configuration

```
editor:
  config:
    importModules:
      - { module: '@ckeditor/ckeditor5-language', exports: [ 'TextPartLanguage' ] }

    toolbar:
      items:
        - textPartLanguage

    language:
      textPartLanguage:
        - { title: 'Englisch', languageCode: 'en' }
        - { title: 'Arabic', languageCode: 'ar' }
```