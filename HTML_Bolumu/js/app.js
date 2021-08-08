var PAGE_ITEM_COUNT = 20;
var API_URL = "http://localhost:8888/api/";

$(function (){
   getSchools();
   getStudentCountFromApi();
   updateScreen();
});

/**
 *
 */
function updateAll() {
   getStudentCountFromApi();
   updateScreen();
}

/**
 *
 * @param id
 */
function deleteStudentModal(id) {
   Swal.fire({
      title: 'Emin misiniz?',
      text: "Öğrenciyi silmek istediğinizden emin misiniz?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Evet',
      cancelButtonText: 'İptal et',
   }).then((result) => {
      if (result.isConfirmed) {
         deleteStudent(id);
      }
   });

}

/**
 *
 * @param id
 */
function deleteStudent(id){

   var url = generateApiUrl("delete-student?student_id="+id);
   var data = {
      "student_id":id
   };
   $.ajax( {
      url : url,
      type : 'DELETE',
      success : function ( data ) {
         if(typeof(data["error"]) != "undefined" && data["error"] !== null && data["error"] !== 0) {
            Swal.fire({
               position: 'bottom-end',
               icon: 'error',
               title: data["message"],
               showConfirmButton: false,
               timer: 2000
            });
         }else {
            Swal.fire({
               position: 'bottom-end',
               icon: 'success',
               title: data["message"],
               showConfirmButton: false,
               timer: 2000
            });
            updateAll();
         }
      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });
}

/**
 *
 * @returns {number}
 */
function getCurrentPageNumber() {
   return  parseInt($("#pageNumberHolder").val().toString());
}

/**
 *
 * @param newPageNumber
 */
function setPageNumber(newPageNumber) {
   $("#pageNumberHolder").val(newPageNumber);
}

/**
 *
 * @returns {number}
 */
function getDefaultPageItemCount() {
   return PAGE_ITEM_COUNT;

}

/**
 *
 * @returns {number}
 */
function getPageItemCount() {
   return parseInt($("#pageItemCountSelect").val());

}

/**
 *
 * @returns {string}
 */
function getApiUrl() {
   return API_URL;
}

/**
 *
 * @param request
 * @returns {string}
 */
function generateApiUrl(request) {
   return getApiUrl() + request;
}
/**
 *
 * @param pageNumber
 * @param pageItemCount
 */
function setList(pageNumber,pageItemCount) {
   var url = generateApiUrl("non-deleted-students-with-paging?pageNumber="+pageNumber.toString()+"&pageItemCount="+pageItemCount.toString());
   $.ajax( {
      url : url,
      type : 'GET',
      success : function ( data ) {
         if(typeof(data["error"]) != "undefined" && data["error"] !== null && data["error"] !== 0) {
            alert("Error");
         }else {
            var htmlData = "";
            htmlData += "<tr>\n" +
                "                <th>#</th>\n" +
                "                <th>Öğrenci Adı</th>\n" +
                "                <th>Öğrenci Soyadı</th>\n" +
                "                <th>TC Kimlik No.</th>\n" +
                "                <th>Okul</th>\n" +
                "                <th>Okul Numarası</th>\n" +
                "                <th>İşlem</th>\n" +
                "            </tr>";
            $.each(data,function (i,item){
               htmlData += "<tr>\n" +
                   "                <td id='id_value-"+item.id+"'>"+item.id+"</td>\n" +
                   "                <td id='name_value-"+item.id+"'>"+item.name+"</td>\n" +
                   "                <td id='surname_value-"+item.id+"'>"+item.surname+"</td>\n" +
                   "                <td id='tc_no_value-"+item.id+"'>"+item.tc_no+"</td>\n" +
                   "                <td id='school_name_value-"+item.id+"'>"+item.school_name+"</td>\n" +
                   "                <td id='school_number_value-"+item.id+"'>"+item.school_number+"</td>\n" +
                   "                <td>\n" +
                   "                    <button type=\"button\" class=\"btn btn-outline-warning\" onclick=\"updateStudentModal("+item.id+");\">\n" +
                   "                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pencil-square\" viewBox=\"0 0 16 16\">\n" +
                   "                            <path d=\"M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z\"/>\n" +
                   "                            <path fill-rule=\"evenodd\" d=\"M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z\"/>\n" +
                   "                        </svg>&nbsp;Düzenle\n" +
                   "                    </button>\n" +
                   "                    <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"deleteStudentModal("+item.id+");\">\n" +
                   "                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash\" viewBox=\"0 0 16 16\">\n" +
                   "                            <path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"/>\n" +
                   "                            <path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"/>\n" +
                   "                        </svg>&nbsp;Sil\n" +
                   "                    </button>\n" +
                   "<input type='number' class='d-none' id='sch_id_value-"+item.id+"' value='"+item.school_id+"'>"+
                   "                </td>\n" +
                   "            </tr>";
            });
            $("#students_table_content").html(htmlData);

         }
      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });
}

/**
 *
 * @param pageNumber
 * @param pageItemCount
 * @param totalPageCount
 */
function setPaging(pageNumber,pageItemCount,totalPageCount) {
   var htmlData = "";
   var totalPagingNumbers = 10;
   if (pageNumber == 1){
      htmlData +="<li class=\"page-item disabled\" id=\"pagingPrev\"><a class=\"page-link\" onclick='goToPage("+(pageNumber-1).toString()+")' href=\"#\" tabindex=\"-1\" aria-disabled=\"true\">Önceki</a></li>";
   }else {
      htmlData +="<li class=\"page-item\" id=\"pagingPrev\"><a class=\"page-link\" onclick='goToPage("+(pageNumber-1).toString()+")' href=\"#\">Önceki</a></li>";
   }

   if (totalPageCount>totalPagingNumbers){
      var diffTotalandPageNumber = totalPageCount-pageNumber;
      if(pageNumber == 1){
         for (i=1;i<=totalPagingNumbers;i++){

            if(i == pageNumber){
               htmlData += "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")' aria-disabled=\"true\">"+i.toString()+"</a></li>";
            }else {
               htmlData += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")'>"+i.toString()+"</a></li>";
            }
         }
      }
      else if (diffTotalandPageNumber<totalPagingNumbers-2){
         for(i=totalPageCount-totalPagingNumbers;i<= totalPageCount-diffTotalandPageNumber;i++){
            if(i == pageNumber){
               htmlData += "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")' aria-disabled=\"true\">"+i.toString()+"</a></li>";
            }else {
               htmlData += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")'>"+i.toString()+"</a></li>";
            }
         }
         for (i = totalPageCount-diffTotalandPageNumber+1;i<=totalPageCount;i++){
            if(i == pageNumber){
               htmlData += "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")' aria-disabled=\"true\">"+i.toString()+"</a></li>";
            }else {
               htmlData += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")'>"+i.toString()+"</a></li>";
            }
         }

      }else {
         for (i=pageNumber-1;i<pageNumber+totalPagingNumbers;i++){
            if(i == pageNumber){
               htmlData += "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")' aria-disabled=\"true\">"+i.toString()+"</a></li>";
            }else {
               htmlData += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")'>"+i.toString()+"</a></li>";
            }
         }
      }

   }else {
      for (i=1;i<=totalPageCount;i++){

         if(i == pageNumber){
            htmlData += "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")' aria-disabled=\"true\">"+i.toString()+"</a></li>";
         }else {
            htmlData += "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" onclick='goToPage("+i.toString()+")'>"+i.toString()+"</a></li>";
         }
      }
   }


   if (pageNumber == totalPageCount){
      htmlData +="<li class=\"page-item disabled\" id=\"pagingNext\"><a class=\"page-link\" onclick='goToPage("+(pageNumber+1).toString()+")' href=\"#\"  aria-disabled=\"true\">Sonraki</a></li>";
   }else {
      htmlData +="<li class=\"page-item\" id=\"pagingNext\"><a class=\"page-link\" onclick='goToPage("+(pageNumber+1).toString()+")' href=\"#\">Sonraki</a></li>";
   }



   $("#paging_ul").html(htmlData);
}

/**
 *
 * @param pageNumber
 */
function goToPage(pageNumber) {
   $("#pageNumberHolder").val(pageNumber);
   updateScreen();
}

/**
 *
 * @returns {number}
 */
function getTotalPageCount() {
   var totalStudent = $("#totalStudentCountHolder").val();
   var itemCount = getPageItemCount();
   var result = Math.ceil(totalStudent / itemCount);
   return result;
}

/**
 *
 */
function updateScreen() {
   setList(getCurrentPageNumber(),getPageItemCount());
   setPaging(getCurrentPageNumber(),getPageItemCount(),getTotalPageCount());
}

/**
 *
 */
function getStudentCountFromApi() {
   var url = generateApiUrl("non-deleted-student-count");
   $.ajax( {
      url : url,
      type : 'GET',
      success : function ( data ) {
         if(typeof(data["error"]) != "undefined" && data["error"] !== null && data["error"] !== 0) {
            Swal.fire({
               position: 'bottom-end',
               icon: 'error',
               title: 'Servisten veri alınırken bir hatayla karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
               showConfirmButton: false,
               timer: 2000
            });
         }else {
            var studentCount = data["student_count"];
            $("#totalStudentCountHolder").val(studentCount);
         }
      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });

}

/**
 * 
 */
function pageItemCountChange() {
   var newPageItemCount = $("#pageItemCountSelect").val();
   setPageNumber(1);
   updateAll();
}

/**
 *
 * @param selected_id
 */
function getSchools(selected_id = -1) {
   var url = generateApiUrl("active-schools");
   $.ajax( {
      url : url,
      type : 'GET',
      success : function ( data ) {
         if(typeof(data["error"]) != "undefined" && data["error"] !== null && data["error"] !== 0) {
            Swal.fire({
               position: 'bottom-end',
               icon: 'error',
               title: data["message"],
               showConfirmButton: false,
               timer: 2000
            });
         }else {
            var htmlData = "";
            $.each(data,function (i,item){
               htmlData += "<option value='"+item.school_id+"'>"+item.school_name+"</option>";
            });
            $("#school_id_input").html(htmlData);
            if (selected_id != -1){
               htmlData = "";
               $.each(data,function (i,item){
                  if (item.school_id == selected_id){
                     htmlData += "<option value='"+item.school_id+"'  selected>"+item.school_name+"</option>";
                  }else {
                     htmlData += "<option value='"+item.school_id+"'>"+item.school_name+"</option>";
                  }
               });

            }
            $("#school_id_input_up").html(htmlData);


         }
      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });
}

/**
 *
 * @constructor
 */
function AddStudentFromForm() {

   var postData = {
      school_id:$("#school_id_input").val(),
      school_no:$("#school_no_input").val(),
      student_name:$("#student_name_input").val(),
      student_surname:$("#student_surname_input").val(),
      student_tcno:$("#student_tcno_input").val()
   };
   var request = "?school_id="+postData["school_id"]+"&school_no="+postData["school_no"]+"&student_name="+postData["student_name"]+"&student_surname="+postData["student_surname"]+"&student_tcno="+postData["student_tcno"];
   var url = generateApiUrl("add-student"+request);
   $.ajax( {
      url : url,
      type : 'POST',
      success : function ( data ) {

         Swal.fire({
            position: 'bottom-end',
            icon: (parseInt(data["error"]) == 1) ? 'error' :'success',
            title: data["message"],
            showConfirmButton: false,
            timer: 2000
         });

         if(parseInt(data["success"]) == 1){
            var addStudentModal = new bootstrap.Modal(document.getElementById('studentAddModal'), {});
            addStudentModal._hideModal();
            $(".modal-backdrop").remove();
            $("#school_id_input").val("");
            $("#student_name_input").val("");
            $("#student_surname_input").val("");
            $("#student_tcno_input").val("");
            updateAll();
            $("#studentAddModal").attr("aria-hidden",true);

         }


      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });

}

/**
 *
 * @param id
 */
function updateStudentModal(id) {
   $("#updateStudentBtn").attr("onclick","updateStudent("+$("#id_value-"+id).html().toString()+")");
   $("#school_no_input_up").val($("#school_number_value-"+id).html().toString());
   $("#student_name_input_up").val($("#name_value-"+id+"").html());
   $("#student_surname_input_up").val($("#surname_value-"+id+"").html());
   $("#student_tcno_input_up").val($("#tc_no_value-"+id+"").html().toString());
   getSchools(parseInt($("#sch_id_value-"+id).val().toString()));


   var updateStudentModal = new bootstrap.Modal(document.getElementById('studentUpdateModal'), {});
   updateStudentModal.show();
}

/**
 *
 * @param id
 */
function updateStudent(id) {
   var request = "update-student?student_id="+id+"&school_no="+$("#school_no_input_up").val()+"&student_name="+$("#student_name_input_up").val()+"&student_surname="+$("#student_surname_input_up").val()+"&student_tcno="+$("#student_tcno_input_up").val()+"&school_id="+$("#school_id_input_up").val();
   var url = generateApiUrl(request);

   $.ajax( {
      url : url,
      type : 'PUT',
      success : function ( data ) {

         Swal.fire({
            position: 'bottom-end',
            icon: (parseInt(data["error"]) == 1) ? 'error' :'success',
            title: data["message"],
            showConfirmButton: false,
            timer: 2000
         });

         if(parseInt(data["success"]) == 1){
            var updateStudentModal = new bootstrap.Modal(document.getElementById('studentUpdateModal'), {});
            updateStudentModal._hideModal();
            $(".modal-backdrop").remove();
            updateAll();
            $("#studentUpdateModal").attr("aria-hidden",true);

         }


      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });

}

/**
 *
 */
function AddSchoolFromForm() {

   var schoolname = $("#school_name_input").val().toString();
   var request = "add-school?schoolname="+schoolname;
   var url = generateApiUrl(request);

   $.ajax( {
      url : url,
      type : 'POST',
      success : function ( data ) {

         Swal.fire({
            position: 'bottom-end',
            icon: (parseInt(data["error"]) == 1) ? 'error' :'success',
            title: data["message"],
            showConfirmButton: false,
            timer: 2000
         });

         if(parseInt(data["success"]) == 1){
            $("#school_name_input").val("");
            getSchools();
         }


      },
      error : function ( jqXhr, textStatus, errorMessage ) {
         Swal.fire({
            position: 'bottom-end',
            icon: 'error',
            title: 'Servise bağlantı ile ilgili bir problemle karşılaşıldı. Lütfen Daha sonra tekrar deneyin.',
            showConfirmButton: false,
            timer: 2500
         });
      }
   });


}