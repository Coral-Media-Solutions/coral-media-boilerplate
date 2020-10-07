/**
 * Coral Desktop 0.1
 * Copyright(c) Coral Media Solutions, LLC.
 * https://www.coralmediasolutions.com
 *
 * NOTE:
 * This code is based on code from the original Ext JS desktop demo and qWikiOffice 1.0
 * I have made many modifications/additions.
 *
 * Ext JS - JavaScript Library
 * Copyright (c) 2006-2011, Sencha Inc.
 * All rights reserved.
 * licensing@sencha.com
 *
 * http://www.sencha.com/license
 */
Ext.app.Addons = {
    'color-picker': {
        id: 'color-picker',
        files: ['addons/color-picker/ColorPicker'],
        hasResources: true
    },
    'hex-field': {
        id: 'hex-field',
        files: ['addons/hex-field/HexField'],
        hasResources: false
    },
    'modal-notice': {
        id: 'modal-notice',
        files: ['addons/modal-notice/ModalNotice'],
        hasResources: false
    },
    'explorer-view': {
        id: 'explorer-view',
        files: ['addons/explorer-view/ExplorerView', 'addons/explorer-view/GroupingExplorerView'],
        hasResources: true
    }
};