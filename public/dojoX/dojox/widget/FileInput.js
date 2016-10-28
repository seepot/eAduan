dojo.provide("dojox.widget.FileInput");
dojo.require("dijit.form._FormWidget");
dojo.require("dijit._Templated");
dojo.declare("dojox.widget.FileInput",
        [dijit.form._FormWidget,dijit._Templated],
        {
        // summary: A styled input type="file"
        //
        // description: A input type="file" form widget, with a button for uploading to be styled via css,
        //      a cancel button to clear selection, and FormWidget mixin to provide standard    
        //      dijit.form.Form
        //     
		// label: String
        //      the title text of the "Browse" button
        label: "Browse ...",
        // cancelText: String
        //      the title of the "Cancel" button
        cancelText: "Cancel",
        // name: String
        //      ugh, this should be pulled from this.domNode
        name: "uploadFile",
        templatePath: dojo.moduleUrl("dojox.widget","FileInput/FileInput.html"),
		// nonRequired: String
		//    this way, the build system knows about me
		nonRequired: "",
});
