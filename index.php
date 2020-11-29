<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Coding Challenge, Rexx System </title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

      <!-- DataTable CSS -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>

      
      <link rel="stylesheet" href="assets/toaster/toast.min.css ">
      <link rel="stylesheet" href="assets/css/style.css ">
   </head>
   <body>
      <div class="jumbotron text-center">
         <h1>Coding Challenge</h1>
         <p>Rexx System</p>
      </div>
      <div class="container">
         <div class="row">
            <div class="loading">Loading&#8230;</div>
         </div>
         <div class="row">
            <div class="col-md-10">
               <h3>Participations</h3>
            </div>
            <div class="col-md-2">
               <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#addFile">+ Import file</button>
            </div>
         </div>
         <div class="clearfix">&nbsp;</div>
         <div class="row">
            <div class="col-md-12">
              <table id="list" class="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                 <th >Employee Name</th>
                              <th >Employee Email</th>
                              <th >Event</th>
                              <th >Date</th>
                              <th >Version</th>
                              <th >Fee</th>
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th colspan="6" class="text-right"></th>
                </tr>
              </tfoot>
            </table>
              
            </table>
         </div>
      </div>
      <footer>
         <!-- Modal -->
         <div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="addFileLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <input type="file" name="json_file" id="json_file" accept="application/json" class="form-control input-sm" >
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
                  </div>
               </div>
            </div>
         </div>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="assets/bootstrap/js/bootstrap.min.js"></script>
         <!-- DataTable Script -->
         <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

         <script src="assets/toaster/toast.min.js"></script>
         <script src="assets/js/common.js"></script>
      </footer>
   </body>
</html>