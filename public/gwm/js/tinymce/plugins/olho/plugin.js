tinymce.PluginManager.add('olho', function(editor) {
    
        function replaceTmpl(str, data) {
            var result = str;
            for (var key in data) {
                result = result.replace('{'+ key +'}',data[key]);
            }
            return result;
        }
    
        function showDialog() {
            var selectedNode = editor.selection.getNode(), name = '',
                isOlhos = selectedNode.tagName == 'SPAN' && editor.dom.getAttrib(selectedNode, 'class').indexOf('olhoWrap') !== -1;
            var selectIndex = (function(){
                if (selectedNode.className.indexOf('olhoWrap') !== -1) {
                    var num = selectedNode.childNodes[0].firstChild.nodeValue.replace(/[^0-9]/g,'');
                    return num;
                }
                else {
                    return selectedNode.childNodes[0];
                }
            }());
    
            if (isOlhos) {
                name = selectedNode.name || decodeURIComponent(selectedNode.getAttribute('data-olho')) || '';
            }
    
            editor.windowManager.open({
                title: "Insert a contents",
                id: 'olho-dialog',
                body: {
                    type: 'textbox',
                    name: 'name',
                    multiline: true,
                    minWidth: 520,
                    minHeight: 100,
                    value : name
                },
                onSubmit: function(e) {
                    var newolhoContent = e.data.name,
                        fixOlhoContent = (function () {
                            return encodeURIComponent(newolhoContent);
                        }()),
                        htmlTemplate = '<span class="olhoWrap matler-olho" id="#wko_ft{FOOTNOTE_INDEX}" contenteditable="false" data-olho="'+fixOlhoContent+'"><button class="olhoBtn">{FOOTNOTE_INDEX}</button></span>',
                        totalOlho = editor.getDoc().querySelectorAll('.olhoBtn'),
                        totalCount = totalOlho.length,
                        html;
    
                    function findNextFD($node)
                    {
                        function nextInDOM(_selector, $node) {
                            var next = getNext($node);
    
                            while(next.length !== 0) {
                                var found = searchFor(_selector, next);
                                if(found !== null) {
                                    return found;
                                }
                                next = getNext(next);
                            }
                            return next;
                        }
                        function getNext($node) {
                            if($node.nextAll().find('.olhoBtn').length > 0) {
                                if ($node.next().hasClass('olhoBtn')) {
                                    return $node.next().children().children();
                                }
                                else {
                                    return $node.nextAll().find('.olhoBtn');
                                }
    
                            }
                            else {
                                if ($node.prop('nodeName') == 'BODY') {
                                    return [];
                                }
                                return getNext($node.parent());
                            }
                        }
                        function searchFor(_selector, $node) {
                            if (!$node) {return false};
                            if($node) {
                                return $node;
                            }
                            else {
                                var found = null;
                                $node.children().each(function() {
                                    if ($node)
                                        found = searchFor(_selector, $(this));
                                });
                                return found;
                            }
                            return null;
                        }
                        var currentClassNot_NextClass = nextInDOM('.olhoBtn', $node);
                        return currentClassNot_NextClass;
                    }
    
                    var nextFD = findNextFD($(editor.selection.getRng().endContainer));
    
                    if(nextFD.length) {
                        nextFD = nextFD[0];
                        var foundIdx;
                        for(foundIdx = 0; foundIdx < totalCount; foundIdx++) {
                            if(nextFD == totalOlho[foundIdx]) {
                                break;
                            }
                        }
                        if (selectIndex < totalCount) {
                            // modify
                            html = replaceTmpl(htmlTemplate,{FOOTNOTE_INDEX : $(totalOlho[selectIndex-1]).html()});
                        }
                        else {
                            // anywhere add
                            html = replaceTmpl(htmlTemplate,{FOOTNOTE_INDEX : $(totalOlho[foundIdx]).html()});
                            editor.selection.collapse(0);
                        }
    
                    } else {
                        // last add
                        html = replaceTmpl(htmlTemplate,{FOOTNOTE_INDEX : totalCount + 1});
                        editor.selection.collapse(0);
                    }
    
                    editor.execCommand('mceInsertContent', false, html);
    
                    // index realignment
                    $(editor.getDoc()).find('.olhoBtn').each(function(idx){
                        $(this).text('Olho ' + (idx+1));
                        $(this).parent().attr('id','#wko_ft' + (idx +1));
                    });
                }
            });
        }
        editor.addCommand('mceOlho', showDialog);
        editor.addButton("olho", {
            title : 'Olho',
            image : tinyMCE.baseURL + '/plugins/olho/img/olho.gif',
            onclick: showDialog,
            stateSelector: 'span.olhoWrap'
        });
    });
    