var tanuki	= function(){
   
    
        
        
    /**********************************************************
    *            OLD CODE
    **********************************************************/    
        
        
    /**********************************************************
    *            Module
    **********************************************************/
    var Module = function(module, group){
        this.init(module, group);
    };
    
    Module.prototype = (function(module, group){
        var constructor = Module;
        
        var init = function(module, group){
            this.group = group;
            this.module = module;
        };
        
        var toString = function(){
            alert("group : "+this.group+" et module : "+this.module);
        };
        
        return {
            constructor:constructor,
            init:init,
            toString:toString
        };
    })();
    
  
    /**********************************************************
    *            Features 
    **********************************************************/
    //returns the fieldset elements within the context
    var getFieldsets = function(contextID){
        //get the context where to search for data
        var context = $("#"+contextID);
        //return all  the fieldsets within the context
        return context.find("fieldset");
    };
    
    //take a list of fieldsets and executes a function func on each fieldset element
    var processFieldsets = function(fieldsets, func){
        //the result array
        var tab = new Array();
        //for each fieldset, we take the group name and list of features
        var l = fieldsets.length;
        for(var i = 0; i<l; i++){
            tab.push(func(fieldsets[i]));
        }
        return tab;
    };

    //takes a fieldset and returns an array of features
    var blockActionDetails = function(fieldset){
        var ACTION = "action";
        var BLOCK = "block";
        var checkboxes;
        var elt,cbText1,cbText2, cbVal1, cbVal2, action,block;
        
        var featureName;
        var features = new Array();
        var forms = $(fieldset).find("form");
        var l = forms.length;
        for(var i = 0; i<l; i++){
            elt = forms[i];
            //get the name of the feature, through the label
            featureName = $($(elt).find("label.feature-name")[0]).text();
            //get the input checkboxes
            checkboxes = $(elt).find("input[type=checkbox]");
            //if there are at least 2 checkboxes
            if(checkboxes.length>1){
            //take each text, from checkboxes (action, block)
                cbText1 = $(checkboxes[0]).parent().text();
                cbText2 = $(checkboxes[1]).parent().text();
                //get the value, checked or not
                cbVal1 = checkboxes[0].checked;
                cbVal2 = checkboxes[1].checked;
                
                //if the checkbox is an action
                if(cbText1.toLowerCase()=== ACTION){
                    action = cbVal1;
                    
                    if(cbText2.toLowerCase()===BLOCK){
                        block = cbVal2;
                    }
                }
                else if(cbText1.toLowerCase()===BLOCK){
                    block = cbVal1;
                    
                    if(cbText2.toLowerCase()===ACTION){
                        action = cbVal2;
                    }
                }
                //we push an object with the feature name, and the values of the checkboxes
                features.push({name:featureName, action:action, block:block});
            }
        }
        return features;
    };
    
    //return a list of the selected features, and the values checked/unchecked for
    //"action" and "block"
    var getCheckedFeaturesList = function(contextID){
        //get all the fieldsets within the context
        var featuresLists = processFieldsets(getFieldsets(contextID),blockActionDetails);
        var tab = new Array();
        var l = featuresLists.length;
        //concat the arrays that contain features into one single feature array
        for(var i = 0; i<l; i++){
            tab = tab.concat(featuresLists[i]);
        }
        
        var solution = new Array();
        l = tab.length;
        //return features that are checked (action or block checked)
        for(var i = 0; i<l; i++){
            elt = tab[i];
            //take only the features that have checked action or block checkboxes
            if(elt.action || elt.block){
                solution.push(elt)
            }
        }
        alert("["+solution.length+" features checked]");
        return solution;
    };
    
    //returns an array of arrays containing the group name, in the first position, and
    //the feature names in subsequent positions.
    var getFeatureList = function(contextID){
        //get all  the fieldsets within the context
        var fieldsets = getFieldsets(contextID);
        
        return processFieldsets(fieldsets, getFeaturesData);
    };
    
    //take a single fieldset node and return the group name and features name.
    var getFeaturesData = function(fieldset){
        var groupName;
        var tab = new Array();
        
        //get the "legend" node
        var legend = $(fieldset).find("legend")[0];
        groupName = $(legend).text();
        //insert the groupName in the first position of the table.
        tab.push(groupName);
        
        //get the checkbox, to check if they are selected
        var checkboxes = $(fieldset).find("input");
        var max = checkboxes.length;

        var elt;
        //for each input, check if selected (here, input type = checkbox)
        for(var i = 0; i<max; i++){
            elt = checkboxes[i];
            //if checked
            if(elt.checked){
            //get the name of the feature
                tab.push($(elt).parent().text());
            }
        }
        return tab;
    };
    
    //wrapper function. The "context" is the elements where to add the generated features
    var createSelectedFeatures = function(featureList, groupName, context){
        var func = privateCreateSelectedFeatures(featureList, groupName);
        $(context).append(func);
        console.log(func);
        console.log(context);
    };
    
    //generate a list of features, with checkboxes for "actions" and "blocks"
    var privateCreateSelectedFeatures = function(featureList, groupName){

        //create a fieldset object
        var fieldClass = "";
        var fieldset = $("<fieldset class=\""+fieldClass+"\"><legend>"+groupName+"</legend></fieldset>");
        //take the list length
        var l = featureList.length;
        //initialise vars out of the loop
        var blockAction;
        var fName, action, block, elt, featureLine,form;
        
        for(var i = 0; i<l; i++){
            elt = featureList[i];
            //initialise from
            form = $("<form class=\"form-inline\"></form>");
            //initialise the feature name
            fName = $("<label class=\"feature-name\">"+elt+"</label>");
            //initialise the action element
            action = $("<label class=\"checkbox\"><input type=\"checkbox\">Action</label>");
            //initialise the block element
            block = $("<label class=\"checkbox\"><input type=\"checkbox\">Block</label>");
            //concatenate these elements into one, called form
            form.append(fName);
            form.append(action);
            form.append(block);
            //append the line to the fieldset
            fieldset.append(form);
        }
        
        var div = $("<div></div>");
        $(div).append(fieldset);
        //console.log(div);
        return div;
    };

 
    /**********************************************************
    *            AJAX
    **********************************************************/
    //create an ajax request of type get
    var ajaxGetRequest = function(path, responseHandler){
        ajaxRequest(path, null, responseHandler, 'get');
    };
    
    //create an ajax request of type post
    var ajaxPostRequest = function(path, data, responseHandler){
        ajaxRequest(path, data, responseHandler, 'post');
    };
 
    //create an ajax request.
    var ajaxRequest = function(path, data, responesHandler, type){
        datatype = 'json';
        
        if(type ==='get'){
            $.ajax({
                    url:path
                ,   datatype:datatype
                ,   type:type
                ,   success:function(data){
                        responesHandler(data);
                }
            });
        }
        else if(type ==='post'){
            $.ajax({
                    url:path
                ,   datatype : datatype
                ,   type:type
                ,   data:data
                ,   success : function(msg){
                        responesHandler(msg);
                }
            });    
        }
    };

    //////////////////////////////////////////////////////////
    
    
    
    return {
		Feature:Feature
        ,getCheckBoxes:getCheckBoxes
        ,attachCheckBoxes:attachCheckBoxes
        ,ajaxPostRequest:ajaxPostRequest
        ,ajaxGetRequest:ajaxGetRequest
        ,addFeatureToXML:addFeatureToXML
        ,createSelectedFeatures:createSelectedFeatures
        ,getFeatureList:getFeatureList
        ,getCheckedFeaturesList:getCheckedFeaturesList
        ,createModule:createModule
    } ;  
    
    
}();//end of module