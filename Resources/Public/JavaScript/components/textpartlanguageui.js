/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/**
 * @module language/textpartlanguageui
 */
import * as Core from '@ckeditor/ckeditor5-core';
import * as Ui from '@ckeditor/ckeditor5-ui';
import * as Utils from '@ckeditor/ckeditor5-utils';
import { stringifyLanguageAttribute } from './utils.js';
/**
 * The text part language UI plugin.
 *
 * It introduces the `'language'` dropdown.
 */
export default class TextPartLanguageUI extends Core.Plugin {
  /**
   * @inheritDoc
   */
  static get pluginName() {
    return 'TextPartLanguageUI';
  }
  /**
   * @inheritDoc
   */
  init() {
    const editor = this.editor;
    const t = editor.t;
    const defaultTitle = editor.config.get('language.l10n.choose');
    const accessibleLabel = editor.config.get('language.l10n.chooseAccessibleLabel');
    // Register UI component.
    editor.ui.componentFactory.add('textPartLanguage', locale => {
      const { definitions, titles } = this._getItemMetadata();
      const languageCommand = editor.commands.get('textPartLanguage');
      const dropdownView = Ui.createDropdown(locale);
      Ui.addListToDropdown(dropdownView, definitions, {
        ariaLabel: accessibleLabel,
        role: 'menu'
      });
      dropdownView.buttonView.set({
        ariaLabel: accessibleLabel,
        ariaLabelledBy: undefined,
        isOn: false,
        withText: true,
        tooltip: accessibleLabel
      });
      dropdownView.extendTemplate({
        attributes: {
          class: [
            'ck-text-fragment-language-dropdown'
          ]
        }
      });
      dropdownView.bind('isEnabled').to(languageCommand, 'isEnabled');
      dropdownView.buttonView.bind('label').to(languageCommand, 'value', value => {
        return (value && titles[value]) || defaultTitle;
      });
      dropdownView.buttonView.bind('ariaLabel').to(languageCommand, 'value', value => {
        const selectedLanguageTitle = value && titles[value];
        if (!selectedLanguageTitle) {
          return accessibleLabel;
        }
        return `${selectedLanguageTitle}, ${accessibleLabel}`;
      });
      // Execute command when an item from the dropdown is selected.
      this.listenTo(dropdownView, 'execute', evt => {
        languageCommand.execute({
          languageCode: evt.source.languageCode,
          textDirection: evt.source.textDirection
        });
        editor.editing.view.focus();
      });
      return dropdownView;
    });
    // Register menu bar UI component.
    editor.ui.componentFactory.add('menuBar:textPartLanguage', locale => {
      const { definitions } = this._getItemMetadata();
      const languageCommand = editor.commands.get('textPartLanguage');
      const menuView = new Ui.MenuBarMenuView(locale);
      menuView.buttonView.set({
        label: accessibleLabel
      });
      const listView = new Ui.MenuBarMenuListView(locale);
      listView.set({
        ariaLabel: t('Language'),
        role: 'menu'
      });
      for (const definition of definitions) {
        if (definition.type != 'button') {
          listView.items.add(new Ui.ListSeparatorView(locale));
          continue;
        }
        const listItemView = new Ui.MenuBarMenuListItemView(locale, menuView);
        const buttonView = new Ui.MenuBarMenuListItemButtonView(locale);
        buttonView.bind(...Object.keys(definition.model)).to(definition.model);
        buttonView.bind('ariaChecked').to(buttonView, 'isOn');
        buttonView.delegate('execute').to(menuView);
        listItemView.children.add(buttonView);
        listView.items.add(listItemView);
      }
      menuView.bind('isEnabled').to(languageCommand, 'isEnabled');
      menuView.panelView.children.add(listView);
      menuView.on('execute', evt => {
        languageCommand.execute({
          languageCode: evt.source.languageCode,
          textDirection: evt.source.textDirection
        });
        editor.editing.view.focus();
      });
      return menuView;
    });
  }
  /**
   * Returns metadata for dropdown and menu items.
   */
  _getItemMetadata() {
    const editor = this.editor;
    const itemDefinitions = new Utils.Collection();
    const titles = {};
    const languageCommand = editor.commands.get('textPartLanguage');
    const options = editor.config.get('language.textPartLanguage');
    const t = editor.locale.t;
    const removeTitle = editor.config.get('language.l10n.remove');
    // Item definition with false `languageCode` will behave as remove lang button.
    itemDefinitions.add({
      type: 'button',
      model: new Ui.ViewModel({
        label: removeTitle,
        languageCode: false,
        withText: true
      })
    });
    itemDefinitions.add({
      type: 'separator'
    });
    for (const option of options) {
      const def = {
        type: 'button',
        model: new Ui.ViewModel({
          label: option.title,
          languageCode: option.languageCode,
          role: 'menuitemradio',
          textDirection: option.textDirection,
          withText: true
        })
      };
      const language = stringifyLanguageAttribute(option.languageCode, option.textDirection);
      def.model.bind('isOn').to(languageCommand, 'value', value => value === language);
      itemDefinitions.add(def);
      titles[language] = option.title;
    }
    return {
      definitions: itemDefinitions,
      titles
    };
  }
}
