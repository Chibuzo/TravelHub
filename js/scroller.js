/**
 * WebKit Div Scroller class
 * @author:Greg Bugaj
 * Initial release
 */
//Namespace
var GB=GB || {};
GB.Scroller=
{
    SCROLL_INREMENT:5,//Amount to scroll per update
    SCROLL_TIME:75,//Time between update Intervals in  MS

    getElementsByClassName:function(classname, node)  {
        if (!node) {
            node = document.getElementsByTagName('BODY')[0];
        }
        var a = [];
        var re = new RegExp('\\b' + classname + '\\b');
        var els = node.getElementsByTagName("*");
        for(var i=0,j=els.length; i<j; i++){
            if(re.test(els[i].className))a.push(els[i]);
        }
        return a;
    },
    //Attached event to the scrollable components
    init:function(){
        var root = document.getElementsByTagName('BODY')[0];
        var containers=GB.Scroller.getElementsByClassName("scroller_container", root);

        for(var i=0;i<containers.length;i++){
            var scroller_container = containers[i];
            //Copy old properties
            var old={
                position:scroller_container.style.position,
                height:scroller_container.style.height,
                overflow:scroller_container.style.overflow
            };

            //Set new props*/
            scroller_container.style.position="absolute";
            scroller_container.style.height="100%";
            scroller_container.style.overflow="none";

            var scroller = GB.Scroller.getElementsByClassName("scroller", scroller_container);
            if(scroller==null){
                alert("There is no DIV with class 'scroller'");
            }
            scroller=scroller[0];//There should be only 1 element in the array

            var contentHeight = scroller.offsetHeight;

            //Move the element back to it original positon with its original values
            scroller_container.style.position=old.position;
            scroller_container.style.height=old.height;
            scroller_container.style.overflow=old.overflow;

            var visibleContentHeight = scroller_container.offsetHeight ;
            var iTimer=0;
            /**
             * Scroll content layer up/down
             * @param {Object} e
             * @param {Object} direction to scroll
             */
            var scrollContent=function(e, direction){
                var t=parseInt(scroller.style.top);
                var cancelTimer=false;
                /*Scroll text up*/
                if(direction == -1 && ((contentHeight+scroller.offsetTop) < visibleContentHeight)){
                    cancelTimer=true;
                }/*Scroll text down*/
                else if(direction == 1/*DOWN*/ && ((contentHeight+scroller.offsetTop) >=  contentHeight)){
                    cancelTimer=true;
                }
                if(cancelTimer){
                    clearInterval(iTimer);
                    return;
                }
                t+=GB.Scroller.SCROLL_INREMENT*direction;
                scroller.style.top=t+"px";
            };


            //Attach events to navigation
            var tapUP = GB.Scroller.getElementsByClassName("scroll_up", scroller_container);
            if(tapUP==null){
                alert("There is no DIV with class 'scroll_up'");
            }
            tapUP=tapUP[0];//There should be only 1 element in the array

            var tapDOWN = GB.Scroller.getElementsByClassName("scroll_down", scroller_container);
            if(tapDOWN==null){
                alert("There is no DIV with class 'scroll_down'");
            }
            tapDOWN=tapDOWN[0];//There should be only 1 element in the array


            tapUP.addEventListener('touchstart', function(e){
                iTimer=setInterval(function(){ scrollContent(e, -1);}, GB.Scroller.SCROLL_TIME);
            }, false);

            tapUP.addEventListener('touchend', function(e){
                clearInterval(iTimer);
            }, false);

            tapDOWN.addEventListener('touchstart', function(e){
                iTimer=setInterval(function(){scrollContent(e, 1);}, GB.Scroller.SCROLL_TIME);
            }, false);

            tapDOWN.addEventListener('touchend', function(e){
                clearInterval(iTimer);
            }, false);

        }//for
    }//function
};

//Initialize all the scrollable components on the page
window.addEventListener('load', function(){ GB.Scroller.init(); }, true);
