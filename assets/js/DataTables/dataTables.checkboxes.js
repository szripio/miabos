/*! Checkboxes 1.2.0-dev
 *  Copyright (c) Gyrocode (www.gyrocode.com)
 *  License: MIT License
 */

/**
 * @summary     Checkboxes
 * @description Checkboxes extension for jQuery DataTables
 * @version     1.2.0-dev
 * @file        dataTables.checkboxes.js
 * @author      Gyrocode (http://www.gyrocode.com/projects/jquery-datatables-checkboxes/)
 * @contact     http://www.gyrocode.com/contacts
 * @copyright   Copyright (c) Gyrocode
 * @license     MIT License
 */

(function( factory ){
   if ( typeof define === 'function' && define.amd ) {
      // AMD
      define( ['jquery', 'datatables.net'], function ( $ ) {
         return factory( $, window, document );
      } );
   }
   else if ( typeof exports === 'object' ) {
      // CommonJS
      module.exports = function (root, $) {
         if ( ! root ) {
            root = window;
         }

         if ( ! $ || ! $.fn.dataTable ) {
            $ = require('datatables.net')(root, $).$;
         }

         return factory( $, root, root.document );
      };
   }
   else {
      // Browser
      factory( jQuery, window, document );
   }
}(function( $, window, document, undefined ) {
'use strict';
var DataTable = $.fn.dataTable;


/**
 * Checkboxes is an extension for the jQuery DataTables library that provides
 * universal solution for working with checkboxes in a table.
 *
 *  @class
 *  @param {object} settings DataTables settings object for the host table
 *  @requires jQuery 1.7+
 *  @requires DataTables 1.10.8+
 *
 *  @example
 *     $('#example').DataTable({
 *        'columnDefs': [
 *           {
 *              'targets': 0,
 *              'checkboxes': true
 *           }
 *        ]
 *     });
 */
var Checkboxes = function ( settings ) {
   // Sanity check that we are using DataTables 1.10.8 or newer
   if ( ! DataTable.versionCheck || ! DataTable.versionCheck( '1.10.8' ) ) {
      throw 'DataTables Checkboxes requires DataTables 1.10.8 or newer';
   }

   this.s = {
      dt: new DataTable.Api( settings ),
      columns: [],
      data: {},
      ignoreSelect: false
   };

   // Get settings object
   this.s.ctx = this.s.dt.settings()[0];

   // Check if checkboxes have already been initialised on this table
   if ( this.s.ctx.checkboxes ) {
      return;
   }

   settings.checkboxes = this;

   this._constructor();
};


Checkboxes.prototype = {
   /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * Constructor
    */

   /**
    * Initialise the Checkboxes instance
    *
    * @private
    */
   _constructor: function ()
   {
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;
      var hasCheckboxes = false;
      var hasCheckboxesSelectRow = false;

      // Retrieve stored state
      var state = dt.state.loaded();

      for(var i = 0; i < ctx.aoColumns.length; i++){
         if (ctx.aoColumns[i].checkboxes){
            var $colHeader = $(dt.column(i).header());

            //
            // INITIALIZATION
            //

            hasCheckboxes = true;

            if(!$.isPlainObject(ctx.aoColumns[i].checkboxes)){
               ctx.aoColumns[i].checkboxes = {};
            }

            ctx.aoColumns[i].checkboxes = $.extend(
               {}, Checkboxes.defaults, ctx.aoColumns[i].checkboxes
            );


            //
            // WORKAROUNDS:
            //
            // DataTables doesn't support natively ability to modify settings on the fly.
            // The following code is a workaround that deals with possible consequences.

            DataTable.ext.internal._fnApplyColumnDefs(ctx, [{
                  'targets': i,
                  'searchable': false,
                  'orderable': false,
                  'width':'1%',
                  'className': 'dt-body-center',
                  'render': function (data, type, full, meta){
                     if(type === 'display'){
                        data = '<input type="checkbox" class="dt-checkboxes">';
                     }
                     return data;
                  }
               }], {}, function (iCol, oDef) {
                  DataTable.ext.internal._fnColumnOptions( ctx, iCol, oDef );
            });

            // Remove "sorting" class
            $colHeader.removeClass('sorting');

            // Detach all event handlers for this column
            $colHeader.off('.dt');


            //
            // DATA
            //

            // Initialize object holding data for selected checkboxes
            self.s.data[i] = {};

            // If state is loaded and contains data for this column
            if(state && state.checkboxes && state.checkboxes.hasOwnProperty(i)){
               // Load previous state
               self.s.data[i] = state.checkboxes[i];
            }

            // Store column index for easy column selection later
            self.s.columns.push(i);


            //
            // CLASSES
            //

            // If row selection is enabled for this column
            if(ctx.aoColumns[i].checkboxes.selectRow){

               // If Select extension is available
               if(DataTable.select){
                  hasCheckboxesSelectRow = true;

               // Otherwise, if Select extension is not available
               } else {
                  // Disable row selection for this column
                  ctx.aoColumns[i].checkboxes.selectRow = false;
               }
            }

            if(ctx.aoColumns[i].checkboxes.selectAll){
               // Save previous HTML content
               $colHeader.data('html', $colHeader.html());

               $colHeader
                  .html('<input type="checkbox">')
                  .addClass('dt-checkboxes-select-all')
                  .attr('data-col', i);
            }
         }
      }

      // If table has at least one checkbox
      if(hasCheckboxes){

         //
         // EVENT HANDLERS
         //

         var $table = $(dt.table().node());
         var $tableBody = $(dt.table().body());
         var $tableContainer = $(dt.table().container());

         // If there is at least one column that has row selection enabled
         if(hasCheckboxesSelectRow){
            $table.addClass('dt-checkboxes-select');

            // Handle row select/deselect event
            $table.on('select.dt.dtCheckboxes deselect.dt.dtCheckboxes', function(e, api, type, indexes){
               self.onSelect(e, type, indexes);
            });

            // Disable Select extension information display
            dt.select.info(false);

            // Update the table information element with selected item summary
            //
            // NOTE: Needed to display correct count of selected rows
            // when using server-side processing mode
            $table.on('draw.dt.dtCheckboxes select.dt.dtCheckboxes deselect.dt.dtCheckboxes', function(){
               self.showInfoSelected();
            });
         }

         // Handle table draw event
         $table.on('draw.dt.dtCheckboxes', function(e){
            self.onDraw(e);
         });

         // Handles checkbox click event
         $tableBody.on('click.dtCheckboxes', 'input.dt-checkboxes', function(e){
            self.onClick(e, this);
         });

         // Handle click on "Select all" control
         $tableContainer.on('click.dtCheckboxes', 'thead th.dt-checkboxes-select-all input[type="checkbox"]', function(e){
            self.onClickSelectAll(e, this);
         });

         // Handle click on heading containing "Select all" control
         $tableContainer.on('click.dtCheckboxes', 'thead th.dt-checkboxes-select-all', function(e) {
            $('input[type="checkbox"]', this).trigger('click');
         });

         // Handle click on "Select all" control in floating fixed header
         $(document).on('click.dtCheckboxes', '.fixedHeader-floating thead th.dt-checkboxes-select-all input[type="checkbox"]', function(e){
            // If FixedHeader is enabled in this instance
            if(ctx._fixedHeader){
               // If header is floating in this instance
               if(ctx._fixedHeader.dom['header'].floating){
                  self.onClickSelectAll(e, this);
               }
            }
         });

         // Handle click on heading containing "Select all" control in floating fixed header
         $(document).on('click.dtCheckboxes', '.fixedHeader-floating thead th.dt-checkboxes-select-all', function(e) {
            // If FixedHeader is enabled in this instance
            if(ctx._fixedHeader){
               // If header is floating in this instance
               if(ctx._fixedHeader.dom['header'].floating){
                  $('input[type="checkbox"]', this).trigger('click');
               }
            }
         });

         // Handle table initialization event
         $table.on('init.dt.dtCheckboxes', function(){

            // If state saving is enabled
            if(ctx.oFeatures.bStateSave){

               // If server-side processing mode is not enabled
               // NOTE: Needed to avoid duplicate call to updateCheckboxes() in onDraw()
               if(!ctx.oFeatures.bServerSide){
                  self.updateCheckboxes({ page: 'all', search: 'none' });

                  $.each(self.s.columns, function(index, colIdx){
                     self.updateSelectAll(colIdx);
                  });
               }

               // Handle state saving event
               $table.on('stateSaveParams.dt.dtCheckboxes', function (e, settings, data){
                  // Store data associated with this plug-in
                  data.checkboxes = self.s.data;
               });
            }
         });

         // Handle table destroy event
         $table.one('destroy.dt.dtCheckboxes', function(e, settings){
            // Detach event handlers
            $(document).off('click.dtCheckboxes');
            $tableContainer.on('.dtCheckboxes');
            $tableBody.off('.dtCheckboxes');
            $table.off('.dtCheckboxes');

            // Clear data
            //
            // NOTE: Needed only to reduce memory footprint
            // in case user saves instance of DataTable object.
            self.s.data = {};

            // Remove added elements
            $('.dt-checkboxes-select-all', $table).each(function(index, el){
               $(el)
                  .html($(el).data('html'))
                  .removeClass('dt-checkboxes-select-all');
            });
         });
      }
   },

   // Updates array holding data for selected checkboxes
   updateData: function(type, selector, isSelected){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      var nodes = [];
      if(type === 'cell' || type === 'row'){
         if(type === 'row'){
            dt.rows(selector).every(function(rowIdx){
               // Get index of the first column that has checkbox and row selection enabled
               var colIdx = self.getSelectRowColIndex();
               if(colIdx !== null){
                  selector = dt.cell(rowIdx, colIdx).node();
               }
            });
         }

         dt.cells(selector).every(function (cellRow, cellCol) {
            // If Checkboxes extension is enabled for this column
            if(ctx.aoColumns[cellCol].checkboxes){
               // Get cell data
               var cellData = this.data();

               // Determine whether data is in the list
               var hasData = ctx.checkboxes.s.data[cellCol].hasOwnProperty(cellData);

               // If checkbox is checked and data is not in the list
               if(isSelected){
                  if(hasData){
                     ctx.checkboxes.s.data[cellCol][cellData]++;
                  } else {
                     ctx.checkboxes.s.data[cellCol][cellData] = 1;
                  }

               // Otherwise, if checkbox is not checked and data is in the list
               } else if (!isSelected && hasData){
                  if(ctx.checkboxes.s.data[cellCol][cellData] === 1){
                     delete ctx.checkboxes.s.data[cellCol][cellData];
                  } else {
                     ctx.checkboxes.s.data[cellCol][cellData]--;
                  }
               }
            }
         });

      } else if(type === 'column'){
         // Determine column index
         var cellCol = dt.column(selector).index();

         // If Checkboxes extension is enabled for this column
         if(ctx.aoColumns[cellCol].checkboxes){
            if(isSelected){
               ctx.checkboxes.s.data[cellCol] = {};
               $.each(dt.column(cellCol).data(), function(index, cellData){
                  if(ctx.checkboxes.s.data[cellCol].hasOwnProperty(cellData)){
                     ctx.checkboxes.s.data[cellCol][cellData]++;
                  } else {
                     ctx.checkboxes.s.data[cellCol][cellData] = 1;
                  }
               });

            } else {
               ctx.checkboxes.s.data[cellCol] = {};
            }
         }
      }

      // If state saving is enabled
      if(ctx.oFeatures.bStateSave){
         // Save state
         dt.state.save();
      }
   },

   // Updates row selection
   updateSelect: function(type, selector, isSelected){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      var rowSelector = [];
      if(type === 'row'){
         rowSelector = selector;

      } else if(type === 'cell'){
         dt.cells(selector).every(function(cellRow, cellCol){
            // If Checkboxes extension is enabled
            // and row selection is enabled for this column
            if(ctx.aoColumns[cellCol].checkboxes && ctx.aoColumns[cellCol].checkboxes.selectRow){
               rowSelector.push(cellRow);
            }
         });
      }

      if(rowSelector.length){
         // If Select extension is available
         if(DataTable.select){
            // Disable select event hanlder temporarily
            self.s.ignoreSelect = true;

            if(isSelected){
               dt.rows(rowSelector).select();
            } else {
               dt.rows(rowSelector).deselect();
            }

            // Re-enable select event handler
            self.s.ignoreSelect = false;
         }
      }
   },

   // Updates state of single checkbox
   updateCheckbox: function(type, selector, isSelected){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      var nodes = [];
      if(type === 'row'){
         dt.rows(selector).every(function(rowIdx){
            // Get index of the first column that has checkbox and row selection enabled
            var colIdx = self.getSelectRowColIndex();
            if(colIdx !== null){
               nodes.push(dt.cell(rowIdx, colIdx).node());
            }
         });

      } else if(type === 'cell'){
         nodes = dt.cells(selector).nodes();
      }

      if(nodes.length){
         $('input.dt-checkboxes', nodes).prop('checked', isSelected);
      }
   },

   // Updates state of multiple checkboxes
   updateCheckboxes: function(opts){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // Enumerate all cells
      var dataSeen = {};
      dt.cells('tr', self.s.columns, opts).every(function(cellRow, cellCol){
         // Get cell data
         var cellData = this.data();

         // If data is in the list
         if(ctx.checkboxes.s.data[cellCol].hasOwnProperty(cellData)){
            // Determine how many times cell with given data was already selected
            if(dataSeen.hasOwnProperty(cellData)){
               dataSeen[cellData]++;
            } else {
               dataSeen[cellData] = 1;
            }

            // If cell needs to be selected
            if(dataSeen[cellData] <= ctx.checkboxes.s.data[cellCol][cellData]){
               var cellNode = this.node();
               self.updateCheckbox('cell', cellNode, true);

               // If Checkboxes extension is enabled
               // and row selection is enabled for this column
               if(ctx.aoColumns[cellCol].checkboxes && ctx.aoColumns[cellCol].checkboxes.selectRow){
                  self.updateSelect('cell', cellNode, true);
               }
            }
         }
      });
   },

   // Handles checkbox click event
   onClick: function(e, ctrl){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // Get cell
      var $cell = $(ctrl).closest('td');

      dt.cell($cell).checkboxes.select(ctrl.checked);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   },

   // Handles row select/deselect event
   onSelect: function(e, type, indexes){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      if(self.s.ignoreSelect){ return; }

      if(type === 'row'){
         self.updateCheckbox('row', indexes, (e.type === 'select') ? true : false);
         self.updateData('row', indexes, (e.type === 'select') ? true : false);

         // Get index of the first column that has checkbox and row selection enabled
         var colIdx = self.getSelectRowColIndex();
         if(colIdx !== null){
            self.updateSelectAll(colIdx);
         }
      }
   },

   // Handles checkbox click event
   onClickSelectAll: function(e, ctrl){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // Calculate column index
      var colIdx = null;
      var $th = $(ctrl).closest('th');

      // If column is fixed using FixedColumns extension
      if($th.parents('.DTFC_Cloned').length){
         var cellIdx = dt.fixedColumns().cellIndex($th);
         colIdx = cellIdx.column;
      } else {
         colIdx = dt.column($th).index();
      }

      var cells = dt.cells('tr', colIdx, {
         page: (
            (ctx.aoColumns[colIdx].checkboxes && ctx.aoColumns[colIdx].checkboxes.selectAllPages)
            ? 'all'
            : 'current'
         ),
         search: 'applied'
      });

      self.updateData('column', colIdx, ctrl.checked);
      self.updateCheckbox('cell', cells.nodes(), ctrl.checked);

       // If row selection is enabled
      if(ctx.aoColumns[colIdx].checkboxes.selectRow){
         var rows = dt.rows({
            page: (
               (ctx.aoColumns[colIdx].checkboxes && ctx.aoColumns[colIdx].checkboxes.selectAllPages)
                  ? 'all'
                  : 'current'
            ),
            search: 'applied'
         });

         self.updateSelect('row', rows.nodes(), ctrl.checked);
      }

      self.updateSelectAll(colIdx);

      // If column is fixed using FixedColumns extension
      if($th.parents('.DTFC_Cloned').length){
         // Update columns in the cloned table
         dt.fixedColumns().update();
      }

      e.stopPropagation();
   },

   // Handles table draw event
   onDraw: function(e){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // If server-side processing is enabled
      if(ctx.oFeatures.bServerSide){
         self.updateCheckboxes({ page: 'current' });
      }

      $.each(self.s.columns, function(index, colIdx){
         self.updateSelectAll(colIdx);
      });
   },

   // Updates state of the "Select all" controls
   updateSelectAll: function(colIdx){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // If Checkboxes extension is enabled for this column
      // and "Select all" control is enabled for this column
      if(ctx.aoColumns[colIdx].checkboxes && ctx.aoColumns[colIdx].checkboxes.selectAll){
         var cells = dt.cells('tr', colIdx, {
            page: (
               (ctx.aoColumns[colIdx].checkboxes.selectAllPages)
               ? 'all'
               : 'current'
            ),
            search: 'applied'
         });

         var $tableContainer = dt.table().container();
         var $checkboxes = $('.dt-checkboxes', cells.nodes());
         var $checkboxesChecked = $checkboxes.filter(':checked');
         var $checkboxesSelectAll = $('.dt-checkboxes-select-all[data-col="' + colIdx + '"] input[type="checkbox"]', $tableContainer);

         // If FixedHeader is enabled in this instance
         if(ctx._fixedHeader){
            // If header is floating in this instance
            if(ctx._fixedHeader.dom['header'].floating){
               $checkboxesSelectAll = $('.fixedHeader-floating .dt-checkboxes-select-all[data-col="' + colIdx + '"] input[type="checkbox"]');
            }
         }

         // If none of the checkboxes are checked
         if ($checkboxesChecked.length === 0) {
            $checkboxesSelectAll.prop({
               'checked': false,
               'indeterminate': false
            });

         // If all of the checkboxes are checked
         } else if ($checkboxesChecked.length === $checkboxes.length) {
            $checkboxesSelectAll.prop({
               'checked': true,
               'indeterminate': false
            });

         // If some of the checkboxes are checked
         } else {
            $checkboxesSelectAll.prop({
               'checked': true,
               'indeterminate': true
            });
         }
      }
   },

   // Updates the information element of the DataTable showing information about the
   // items selected. Based on info() method of Select extension.
   showInfoSelected: function(){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      if ( ! ctx.aanFeatures.i ) {
         return;
      }

      var $output  = $('<span class="select-info"/>');
      var add = function(name, num){
         $output.append( $('<span class="select-item"/>').append( dt.i18n(
            'select.'+name+'s',
            { _: '%d '+name+'s selected', 0: '', 1: '1 '+name+' selected' },
            num
         ) ) );
      };

      // Get index of the first column that has checkbox and row selection enabled
      var colIdx = self.getSelectRowColIndex();

      // If there is a column that has checkbox and row selection enabled
      if(colIdx !== null){
         // Count number of selected rows
         var countRows = 0;
         for (var cellData in ctx.checkboxes.s.data[colIdx]){
            if (ctx.checkboxes.s.data[colIdx].hasOwnProperty(cellData)){
               countRows += ctx.checkboxes.s.data[colIdx][cellData];
            }
         }

         add('row', countRows);

         // Internal knowledge of DataTables to loop over all information elements
         $.each( ctx.aanFeatures.i, function ( i, el ) {
            var $el = $(el);

            var $existing = $el.children('span.select-info');
            if($existing.length){
               $existing.remove();
            }

            if($output.text() !== ''){
               $el.append($output);
            }
         });
      }
   },

   // Gets cell index
   getCellIndex: function(cell){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      // If FixedColumns extension is available
      if(DataTable.FixedColumns){
         return dt.fixedColumns().cellIndex(cell);

      } else {
         return dt.cell(cell).index();
      }
   },

   // Gets index of the first column that has checkbox and row selection enabled
   getSelectRowColIndex: function(){
      var self = this;
      var dt = self.s.dt;
      var ctx = self.s.ctx;

      var colIdx = null;

      for(var i = 0; i < ctx.aoColumns.length; i++){
         // If Checkboxes extension is enabled
         // and row selection is enabled for this column
         if(ctx.aoColumns[i].checkboxes && ctx.aoColumns[i].checkboxes.selectRow){
            colIdx = i;
            break;
         }
      }

      return colIdx;
   }
};


/**
 * Checkboxes default settings for initialisation
 *
 * @namespace
 * @name Checkboxes.defaults
 * @static
 */
Checkboxes.defaults = {
   /**
    * Enable / disable row selection
    *
    * @type {Boolean}
    * @default  `false`
    */
   selectRow: false,

   /**
    * Enable / disable "select all" control in the header
    *
    * @type {Boolean}
    * @default  `true`
    */
   selectAll: true,

   /**
    * Enable / disable ability to select checkboxes from all pages
    *
    * @type {Boolean}
    * @default  `true`
    */
   selectAllPages: true
};


/*
 * API
 */
var Api = $.fn.dataTable.Api;

// Doesn't do anything - work around for a bug in DT... Not documented
Api.register( 'checkboxes()', function () {
   return this;
} );

Api.registerPlural( 'columns().checkboxes.select()', 'column().checkboxes.select()', function ( select ) {
   if(typeof select === 'undefined'){ select = true; }

   return this.iterator( 'column', function (ctx, colIdx){
      if(ctx.checkboxes){
         var selector = this.cells('tr', colIdx).nodes();
         ctx.checkboxes.updateCheckbox('cell', selector, (select) ? true : false);
         ctx.checkboxes.updateData('column', colIdx, (select) ? true : false);
         ctx.checkboxes.updateSelect('cell', selector, (select) ? true : false);
         ctx.checkboxes.updateSelectAll(colIdx);
      }
   }, 1 );
} );

Api.registerPlural( 'cells().checkboxes.select()', 'cell().checkboxes.select()', function ( select ) {
   if(typeof select === 'undefined'){ select = true; }

   return this.iterator( 'cell', function ( ctx, rowIdx, colIdx ) {
      if(ctx.checkboxes){
         var selector = { row: rowIdx, column: colIdx };
         ctx.checkboxes.updateCheckbox('cell', selector, (select) ? true : false);
         ctx.checkboxes.updateData('cell', selector, (select) ? true : false);
         ctx.checkboxes.updateSelect('cell', selector, (select) ? true : false);
         ctx.checkboxes.updateSelectAll(colIdx);
      }
   }, 1 );
} );

Api.registerPlural( 'columns().checkboxes.deselect()', 'column().checkboxes.deselect()', function () {
   return this.checkboxes.select(false);
} );

Api.registerPlural( 'cells().checkboxes.deselect()', 'cell().checkboxes.deselect()', function () {
   return this.checkboxes.select(false);
} );

Api.registerPlural( 'columns().checkboxes.selected()', 'column().checkboxes.selected()', function () {
   return this.iterator( 'column', function (ctx, colIdx){
      if(ctx.aoColumns[colIdx].checkboxes){
         var data = [];

         $.each(ctx.checkboxes.s.data[colIdx], function(cellData, countRows){
            for(var i = 0; i < countRows; i++){
               data.push(cellData);
            }
         });

         return data;
      } else {
         return [];
      }
   }, 1 );
} );


/**
 * Version information
 *
 * @name Checkboxes.version
 * @static
 */
Checkboxes.version = '1.2.0-dev';



$.fn.DataTable.Checkboxes = Checkboxes;
$.fn.dataTable.Checkboxes = Checkboxes;


// Attach a listener to the document which listens for DataTables initialisation
// events so we can automatically initialise
$(document).on( 'preInit.dt.dtCheckboxes', function (e, settings, json) {
   if ( e.namespace !== 'dt' ) {
      return;
   }

   new Checkboxes( settings );
} );


return Checkboxes;
}));
