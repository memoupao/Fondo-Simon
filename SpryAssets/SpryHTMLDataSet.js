Spry.Data.HTMLDataSet = function(dataSetURL, sourceElementID, dataSetOptions)
{
	this.sourceElementID = sourceElementID; 
	this.sourceElement = null;

	this.sourceWasInitialized = false;
	this.usesExternalFile = (dataSetURL != null) ? true : false;
	
	this.firstRowAsHeaders = true;
	this.useColumnsAsRows = false;
	this.columnNames = null;
	this.hideDataSourceElement = true;
	
	this.rowSelector = null;
	this.dataSelector = null;
	this.removeUnbalancedRows = true;

	this.tableModeEnabled = true;

	Spry.Data.HTTPSourceDataSet.call(this, dataSetURL, dataSetOptions);
};


Spry.Data.HTMLDataSet.prototype = new Spry.Data.HTTPSourceDataSet();
Spry.Data.HTMLDataSet.prototype.constructor = Spry.Data.HTMLDataSet;


Spry.Data.HTMLDataSet.prototype.getDataRefStrings = function() 
{
	var dep = [];
	if (this.url) 
		dep.push(this.url);
	if (typeof this.sourceElementID == "string") 
		dep.push(this.sourceElementID);
	
	return dep;
};

Spry.Data.HTMLDataSet.prototype.setDisplay = function(ele, display)
{
	if( ele )
		ele.style.display = display;
};

Spry.Data.HTMLDataSet.prototype.initDataSource = function(callLoadData)
{
	if (!this.loadDependentDataSets())
		return;
	if (!this.usesExternalFile)
	{
		this.setSourceElement();
		if (this.hideDataSourceElement)
			this.setDisplay(this.sourceElement, "none");
	}
};


Spry.Data.HTMLDataSet.prototype.setSourceElement = function (externalDataElement)
{
	this.sourceElement = null;
	if (!this.sourceElementID) 
	{
	  if (externalDataElement)
  	  this.sourceElement = externalDataElement;
  	else
  	{
  	  this.hideDataSourceElement = false;
  	  this.sourceElement = document.body;
  	}
	  return; 
	}
	
	var sourceElementID = Spry.Data.Region.processDataRefString(null, this.sourceElementID, this.dataSetsForDataRefStrings);
	if (!this.usesExternalFile)
	   this.sourceElement = Spry.$(sourceElementID);
	else
    if (externalDataElement) 
    {
      var foundElement = false;
      var sources = Spry.Utils.getNodesByFunc(externalDataElement, function(node)
    	{
    	    if (foundElement) 
    	      return false;
    			if (node.nodeType != 1)
    				return false;
    			if (node.id && node.id.toLowerCase() == sourceElementID.toLowerCase())
    			{
    			  foundElement = true;
    			  return true;
    			}
      });
      this.sourceElement = sources[0];
    }
	if (!this.sourceElement) 
		Spry.Debug.reportError("Spry.Data.HTMLDataSet: '" + sourceElementID + "' is not a valid element ID");
};
Spry.Data.HTMLDataSet.prototype.getSourceElement = function() { return this.sourceElement; };
Spry.Data.HTMLDataSet.prototype.getSourceElementID = function() { return this.sourceElementID; };
Spry.Data.HTMLDataSet.prototype.setSourceElementID = function(sourceElementID)
{
	if (this.sourceElementID != sourceElementID)
	{
		this.sourceElementID = sourceElementID;
		this.recalculateDataSetDependencies();
		this.dataWasLoaded = false;
	}
};
Spry.Data.HTMLDataSet.prototype.getDataSelector = function() { return this.dataSelector; };
Spry.Data.HTMLDataSet.prototype.setDataSelector = function(dataSelector)
{ 
  if (this.dataSelector != dataSelector)
  {
     this.dataSelector = dataSelector;
  	 this.dataWasLoaded = false;
  }
};

Spry.Data.HTMLDataSet.prototype.getRowSelector = function() { return this.rowSelector; };
Spry.Data.HTMLDataSet.prototype.setRowSelector = function(rowSelector)
{ 
  if (this.rowSelector != rowSelector)
  {
     this.rowSelector = rowSelector;
  	 this.dataWasLoaded = false;
  }
};


Spry.Data.HTMLDataSet.prototype.loadDataIntoDataSet = function(rawDataDoc)
{
	var responseText = rawDataDoc;
	responseText = Spry.Data.HTMLDataSet.cleanupSource(responseText);

	var div = document.createElement("div");
	div.id = "htmlsource" + this.internalID;
	div.innerHTML = responseText;

	this.setSourceElement(div);
	if (this.sourceElement)
	{
		var parsedStructure = this.getDataFromSourceElement();
		if (parsedStructure) 
		{
			this.dataHash = parsedStructure.dataHash;
			this.data = parsedStructure.data;
		}		
	}
	this.dataWasLoaded = true;
	div = null;
};
Spry.Data.HTMLDataSet.prototype.loadDependentDataSets = function() 
{
	if (this.hasDataRefStrings)
	{
		var allDataSetsReady = true;

		for (var i = 0; i < this.dataSetsForDataRefStrings.length; i++)
		{
			var ds = this.dataSetsForDataRefStrings[i];
			if (ds.getLoadDataRequestIsPending())
				allDataSetsReady = false;
			else if (!ds.getDataWasLoaded())
			{
				ds.loadData();
				allDataSetsReady = false;
			}
		}
		if (!allDataSetsReady)
			return false;
	}
	return true;
};
Spry.Data.HTMLDataSet.prototype.loadData = function()
{
	this.cancelLoadData();
	this.initDataSource();
	
	var self = this;
	if (!this.usesExternalFile) 
	{
		this.notifyObservers("onPreLoad");
		
		this.dataHash = new Object;
		this.data = new Array;
		this.dataWasLoaded = false;
		this.unfilteredData = null;
		this.curRowID = 0;
		
		this.pendingRequest = new Object;
		this.pendingRequest.timer = setTimeout(function()
		{
			self.pendingRequest = null;
			var parsedStructure = self.getDataFromSourceElement();
			if (parsedStructure) 
			{
				self.dataHash = parsedStructure.dataHash;
				self.data = parsedStructure.data;
			}
			self.dataWasLoaded = true;
			
			self.disableNotifications();
			self.filterAndSortData();
			self.enableNotifications();
			
			self.notifyObservers("onPostLoad");
			self.notifyObservers("onDataChanged");	
		}, 0); 
	}
	else 
	{
		var url = Spry.Data.Region.processDataRefString(null, this.url, this.dataSetsForDataRefStrings);
		var postData = this.requestInfo.postData;
		if (postData && (typeof postData) == "string") 
			postData = Spry.Data.Region.processDataRefString(null, postData, this.dataSetsForDataRefStrings);
		this.notifyObservers("onPreLoad");
		this.dataHash = new Object;
		this.data = new Array;
		this.dataWasLoaded = false;
		this.unfilteredData = null;
		this.curRowID = 0;
		var req = this.requestInfo.clone();
		req.url = url;
		req.postData = postData;
		this.pendingRequest = new Object;
		this.pendingRequest.data = Spry.Data.HTTPSourceDataSet.LoadManager.loadData(req, this, this.useCache);
	}
};


Spry.Data.HTMLDataSet.cleanupSource = function (source)
{
  source = source.replace(/<(img|script|link|frame|iframe|input)([^>]+)>/gi, function(a,b,c) {
			return '<' + b + c.replace(/\b(src|href)\s*=/gi, function(a, b) {
				return 'spry_'+ b + '=';
			}) + '>';
		});
	return source;
};


Spry.Data.HTMLDataSet.undoCleanupSource = function (source)
{
	source = source.replace(/<(img|script|link|frame|iframe|input)([^>]+)>/gi, function(a,b,c) {
			return '<' + b + c.replace(/\bspry_(src|href)\s*=/gi, function(a, b) {
				return b + '=';
			}) + '>';
		});
	return source;
};
Spry.Data.HTMLDataSet.normalizeColumnName = function(colName) 
{
	if (colName)
	{
		colName = colName.replace(/(?:^[\s\t]+|[\s\t]+$)/gi, "");
		colName = colName.replace(/<\/?([a-z]+)([^>]+)>/gi, "");
		colName = colName.replace(/[\s\t]+/gi, "_");
	}
	return colName;
};


Spry.Data.HTMLDataSet.prototype.getDataFromSourceElement = function() 
{
	if (!this.sourceElement) 
    return null;

	var extractedData;
	var usesTable = (this.tableModeEnabled && this.sourceElement.nodeName.toLowerCase() == "table");
	if (usesTable)
		extractedData = this.getDataFromHTMLTable();
	else
		extractedData = this.getDataFromNestedStructure();

	if (!extractedData)
     return null;
	if (this.useColumnsAsRows) 
	{
	   var flipedData = new Array;
	   for (var rowIdx = 0; rowIdx < extractedData.length; rowIdx++)
	   {
	     var row = extractedData[rowIdx];
	     for (var colIdx = 0; colIdx < row.length; colIdx++) 
	     {
	       if (!flipedData[colIdx]) flipedData[colIdx] = new Array;
	       flipedData[colIdx][rowIdx]= row[colIdx];
	     }
	   }
	   extractedData = flipedData;
	}
	var parsedStructure = new Object();
	parsedStructure.dataHash = new Object;
	parsedStructure.data = new Array;
	if (extractedData.length == 0) 
	   return parsedStructure;
	var maxColumnCount = 0;

	for (var i = 0; i < extractedData.length; i++)
	{
		var len = extractedData[i].length;
		if (maxColumnCount < len)
			maxColumnCount = len;
	}
	var columnNames = new Array;
	var firstRowOfData = extractedData[0];
	for (var colIdx = 0; colIdx < maxColumnCount; colIdx++)
	{
		if (usesTable && this.firstRowAsHeaders)
			columnNames[colIdx] = Spry.Data.HTMLDataSet.normalizeColumnName(firstRowOfData[colIdx]);
		if (!columnNames[colIdx])
			columnNames[colIdx] = "column" + colIdx;
	}
	if (this.columnNames && this.columnNames.length) 
	{
		var numCols = (maxColumnCount < this.columnNames.length) ? maxColumnCount : this.columnNames.length;
		for (var i = 0; i < numCols; i++) {
			if (this.columnNames[i])
				columnNames[i] = this.columnNames[i];
		}
	}
	var nextID = 0;
	var firstDataRowIndex = (usesTable && this.firstRowAsHeaders) ? 1: 0;
	
	for (var rowIdx = firstDataRowIndex; rowIdx < extractedData.length; rowIdx++)
	{
		var row = extractedData[rowIdx];
		if (this.removeUnbalancedRows && columnNames.length != row.length)
		{
			continue;
		}
		var rowObj = {};
		for (var colIdx = 0; colIdx < columnNames.length; colIdx++)
		{
			var colValue = row[colIdx];
			rowObj[columnNames[colIdx]] = (typeof colValue == "undefined") ? "" : colValue;
		}
		rowObj['ds_RowID'] = nextID++;
		parsedStructure.dataHash[rowObj['ds_RowID']] = rowObj;
		parsedStructure.data.push(rowObj);
	}
	return parsedStructure;
};
Spry.Data.HTMLDataSet.getElementChildren = function(element)
{
	var children = [];
	var child = element.firstChild;
	while (child)
	{
		if (child.nodeType == 1)
			children.push(child);
		child = child.nextSibling;
	}
	return children;
};
Spry.Data.HTMLDataSet.prototype.getDataFromHTMLTable = function()
{
  var tHead = this.sourceElement.tHead;
  var tBody = this.sourceElement.tBodies[0];
  var rowsHead = [];
  var rowsBody = [];
  if (tHead) rowsHead = Spry.Data.HTMLDataSet.getElementChildren(tHead);
  if (tBody) rowsBody = Spry.Data.HTMLDataSet.getElementChildren(tBody);
  var extractedData = new Array;
  var rows = rowsHead.concat(rowsBody);
  if (this.rowSelector) rows = Spry.Data.HTMLDataSet.applySelector(rows, this.rowSelector);
  for (var rowIdx = 0; rowIdx < rows.length; rowIdx++)
  {
     var row = rows[rowIdx];
     var dataRow;
     if (extractedData[rowIdx]) dataRow = extractedData[rowIdx];
     else dataRow = new Array;
     var offset = 0;
     var cells = row.cells;
     if (this.dataSelector) cells = Spry.Data.HTMLDataSet.applySelector(cells, this.dataSelector);
     for (var cellIdx=0; cellIdx < cells.length; cellIdx++)
     {
       var cell = cells[cellIdx];
       var nextCellIndex = cellIdx + offset;
       while (dataRow[nextCellIndex])
       {
          offset ++;
          nextCellIndex ++;
       }
       var cellValue = Spry.Data.HTMLDataSet.undoCleanupSource(cell.innerHTML);
       dataRow[nextCellIndex] = cellValue;
       var colspan = cell.colSpan;
       if (colspan == 0) colspan = 1;
       var startOffset = offset;
       for (var offIdx = 1; offIdx < colspan; offIdx++)
       {
         offset ++;
         nextCellIndex = cellIdx + offset;
         dataRow[nextCellIndex] = cellValue;
       }
       var rowspan = cell.rowSpan;
       if (rowspan == 0) rowspan = 1;
       for (var rowOffIdx = 1; rowOffIdx < rowspan; rowOffIdx++)
       {
         nextRowIndex = rowIdx + rowOffIdx;
         var nextDataRow;
         if (extractedData[nextRowIndex]) nextDataRow = extractedData[nextRowIndex];
         else nextDataRow = new Array;
         
         var rowSpanCellOffset = startOffset;
         for (var offIdx = 0; offIdx < colspan; offIdx++)
         {
           nextCellIndex = cellIdx + rowSpanCellOffset;
           nextDataRow[nextCellIndex] = cellValue;
           rowSpanCellOffset ++;
         }
         extractedData[nextRowIndex] = nextDataRow;
       }
      }
     extractedData[rowIdx] = dataRow;
  }
  return extractedData;
};
Spry.Data.HTMLDataSet.prototype.getDataFromNestedStructure = function()
{
  var extractedData = new Array;
  
  if (this.sourceElementID && !this.rowSelector && !this.dataSelector) 
  {
     extractedData[0] = [Spry.Data.HTMLDataSet.undoCleanupSource(this.sourceElement.innerHTML)];
     return extractedData;
  }
  
  var self = this;
  var rows = [];
  if (!this.rowSelector)
     rows = [this.sourceElement];
  else
     rows = Spry.Utils.getNodesByFunc(this.sourceElement, function(node) { 
            return Spry.Data.HTMLDataSet.evalSelector(node, self.sourceElement, self.rowSelector); 
           }); 
  for (var rowIdx = 0; rowIdx < rows.length; rowIdx++)
  {
    var row = rows[rowIdx];
    var cells = [];
    if (!this.dataSelector)
      cells = [row];
    else
      cells = Spry.Utils.getNodesByFunc(row, function(node) { 
               return Spry.Data.HTMLDataSet.evalSelector(node, row, self.dataSelector); 
              });
              
    extractedData[rowIdx] = new Array;
    for (var cellIdx = 0; cellIdx < cells.length; cellIdx ++)
       extractedData[rowIdx][cellIdx] = Spry.Data.HTMLDataSet.undoCleanupSource(cells[cellIdx].innerHTML);
  }
  return extractedData;
};
Spry.Data.HTMLDataSet.applySelector = function(collection, selector, root)
{
   var newCollection = [];
   for (var idx = 0; idx < collection.length; idx++)
   {
     var node = collection[idx];
     if (Spry.Data.HTMLDataSet.evalSelector(node, root?root:node.parentNode, selector))
        newCollection.push(node);
   }
   return newCollection;
};
Spry.Data.HTMLDataSet.evalSelector = function (node, root, selector)
{
  if (node.nodeType != 1)
 		return false;
 	if (node == root)
 	  return false;
  var selectors = selector.split(",");
  for (var idx = 0; idx < selectors.length; idx ++)
  {
    var currentSelector = selectors[idx].replace(/^\s+/, "").replace(/\s+$/, "");
   	var tagName = null;
   	var className = null;
   	var id = null;
   	var selected = true;
   	if (currentSelector.substring(0,1) == ">") 
   	{
   	    if (node.parentNode != root) 
   	      selected = false;
   	    else
   	      currentSelector = currentSelector.substring(1).replace(/^\s+/, "");
   	}
   	if (selected) 
   	{
     	tagName = currentSelector.toLowerCase();
     	if (currentSelector.indexOf(".") != -1)
     	{
     	  var parts = currentSelector.split(".");
     	  tagName = parts[0];
     	  className = parts[1];
     	}
     	else if (currentSelector.indexOf("#") != -1)
     	{
     	  var parts = currentSelector.split("#");
     	  tagName = parts[0];
     	  id = parts[1];
     	}
   	}
   	if (selected && tagName != '' && tagName != '*')
   	    if (node.nodeName.toLowerCase() != tagName) 
   	       selected = false;
   	if (selected && id && node.id != id)
   	    selected = false;
    	if (selected && className && node.className.search(new RegExp('\\b' + className + '\\b', 'i')) ==-1) 
   	    selected = false;
   	if (selected)
   	 return true;
  }
  return false;
};
