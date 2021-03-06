$(document).ready(function() {

   var $calendar = $('#calendar');
   var id = 10;

   $calendar.weekCalendar({
      displayOddEven:true,
      timeslotsPerHour : 4,
      allowCalEventOverlap : true,
      overlapEventsSeparate: true,
      firstDayOfWeek : 1,
      businessHours :{start: 8, end: 22, limitDisplay: true },
      daysToShow : 7,
      use24Hour: true,
      version: '2.0-dev',
      updateLayoutOptions: {
        startOnFirstDayOfWeek: true,
        firstDayOfWeek: true,
        daysToShow: true,
        displayOddEven: true,
        timeFormat: true,
        dateFormat: true,
        use24Hour: true,
        useShortDayNames: true,
        businessHours: true,
        timeslotHeight: true,
        timeslotsPerHour: true,
        buttonText: true,
        height: true,
        shortMonths: true,
        longMonths: true,
        shortDays: true,
        longDays: true,
        textSize: true,
        users: true,
        showAsSeparateUsers: true,
        displayFreeBusys: true
      },
      switchDisplay: {'work week': 5, 'full week': 7},
      title: function(daysToShow) {
			return daysToShow == 1 ? '%date%' : '%start% - %end%';
      },
      height : function($calendar) {
         return $(window).height() - $("h1").outerHeight() - 1;
      },
      eventRender : function(calEvent, $event) {
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.addClass('past');
            $event.find(".wc-time").css({
               "backgroundColor" : "#999",
               "border" : "1px solid #888"
            });
         }
         if (calEvent.validate == true) {
            $event.addClass('validate');
            $event.find(".wc-time").css({
               "backgroundColor" : "forestgreen",
               "border" : "1px solid darkgreen"
            });
         }
         if (calEvent.refused == true) {
            $event.addClass('refused');
            $event.find(".wc-time").css({
               "backgroundColor" : "red",
               "border" : "1px solid darkred"
            });
         }
         if(calEvent.readOnly) {
           $event.addClass('read-only');
         }
      },
      draggable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      resizable : function(calEvent, $event) {
         return calEvent.readOnly != true;
      },
      eventNew : function(calEvent, $event) {
         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']");
         var bodyField = $dialogContent.find("textarea[name='body']");


         $dialogContent.dialog({
            modal: true,
            title: "Ajouter un Événement",
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               ajouter : function() {
                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();

                   $.ajax({url: AJAX_URLS.addEvent, type: "post", data:{start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg) {
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                    }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });

                  $calendar.weekCalendar("removeUnsavedEvents");
                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               annuler : function() {
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

      },
      eventDrop : function(calEvent, $event) {
          $.ajax({url: AJAX_URLS.editEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                    }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });
      },
      eventResize : function(calEvent, $event) {
           $.ajax({url:AJAX_URLS.editEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                    }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });
      },
      eventClick : function(calEvent, $event) {

         if (calEvent.readOnly) {
            return;
         }

         var $dialogContent = $("#event_edit_container");
         resetForm($dialogContent);
         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         var titleField = $dialogContent.find("input[name='title']").val(calEvent.title);
         var bodyField = $dialogContent.find("textarea[name='body']");
         bodyField.val(calEvent.body);

         $dialogContent.dialog({
            modal: true,
            title: "Editer - " + calEvent.title,
            close: function() {
               $dialogContent.dialog("destroy");
               $dialogContent.hide();
               $('#calendar').weekCalendar("removeUnsavedEvents");
            },
            buttons: {
               valider : function() {
                  $.ajax({url: AJAX_URLS.validateEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                    }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });

                $calendar.weekCalendar("updateEvent", calEvent);
                $dialogContent.dialog("close");

               },
               refuser : function() {
                  $.ajax({url: AJAX_URLS.refusedEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                    }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });

                $calendar.weekCalendar("updateEvent", calEvent);
                $dialogContent.dialog("close");

               },
               modifier : function() {

                  calEvent.start = new Date(startField.val());
                  calEvent.end = new Date(endField.val());
                  calEvent.title = titleField.val();
                  calEvent.body = bodyField.val();
                   $.ajax({url: AJAX_URLS.editEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                  }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });

                  $calendar.weekCalendar("updateEvent", calEvent);
                  $dialogContent.dialog("close");
               },
               "supprimer" : function(msg) {
                   $.ajax({url: AJAX_URLS.removeEvent, type: "post", data:{eventID: calEvent.id, start: calEvent.start.toJSON(), end:calEvent.end.toJSON(), title:calEvent.title},
                    success: function(msg){
                      toastr.success(msg);
                      $calendar.weekCalendar("refresh");
                   }, error: function(xhr) {
                      var err = eval("(" + xhr.responseText + ")");
                      toastr.error(err.msg);
                      $calendar.weekCalendar("refresh");
                    }
                  });

                  $calendar.weekCalendar("removeEvent", calEvent.id);
                  $dialogContent.dialog("close");
               }
            }
         }).show();

         var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
         var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
         $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
         setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));
         $(window).resize().resize(); //fixes a bug in modal overlay size ??

      },
      eventMouseover : function(calEvent, $event) {
      },
      eventMouseout : function(calEvent, $event) {
      },
      noEvents : function() {

      },
      data: function(start, end, callback) {
        $.getJSON(AJAX_URLS.getEventData, {
           start: start.getTime(),
           end: end.getTime()
         },  function(result) {
           callback(result);
         });
      }
   });

   function resetForm($dialogContent) {
      $dialogContent.find("input").val("");
      $dialogContent.find("textarea").val("");
   }

   /*
    * Sets up the start and end time fields in the calendar event
    * form for editing based on the calendar event being edited
    */
   function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {

      $startTimeField.empty();
      $endTimeField.empty();

      for (var i = 0; i < timeslotTimes.length; i++) {
         var startTime = timeslotTimes[i].start;
         var endTime = timeslotTimes[i].end;
         var startSelected = "";
         if (startTime.getTime() === calEvent.start.getTime()) {
            startSelected = "selected=\"selected\"";
         }
         var endSelected = "";
         if (endTime.getTime() === calEvent.end.getTime()) {
            endSelected = "selected=\"selected\"";
         }
         $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
         $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

         $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
         $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();

      }
      $endTimeOptions = $endTimeField.find("option");
      $startTimeField.trigger("change");
   }

   var $endTimeField = $("select[name='end']");
   var $endTimeOptions = $endTimeField.find("option");
   var $timestampsOfOptions = {start:[],end:[]};

   //reduces the end time options to be only after the start time options.
   $("select[name='start']").change(function() {
      var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
      var currentEndTime = $endTimeField.find("option:selected").val();
      $endTimeField.html(
            $endTimeOptions.filter(function() {
               return startTime < $timestampsOfOptions.end[$(this).text()];
            })
            );

      var endTimeSelected = false;
      $endTimeField.find("option").each(function() {
         if ($(this).val() === currentEndTime) {
            $(this).attr("selected", "selected");
            endTimeSelected = true;
            return false;
         }
      });

      if (!endTimeSelected) {
         //automatically select an end date 2 slots away.
         $endTimeField.find("option:eq(1)").attr("selected", "selected");
      }

   });

});
