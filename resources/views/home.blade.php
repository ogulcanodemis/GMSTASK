@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-9 mb-5">
            <form onsubmit="event.preventDefault(); createStudent();" class="d-flex align-items-end justify-content-between">
                <div class="col-4">
                    <label for="name">Adı:</label>
                    <input type="text" id="name" name="name" class="form-control shadow-none" required>
                </div>
                <div class="col-4">
                    <label for="school_id">Okulu:</label>
                    <select id="school_id" name="school_id" class="form-select shadow-none" required>
                        <option value="">Okul Seçin</option>
                        <!-- Okul seçeneklerini dinamik olarak burada oluşturabilirsiniz -->
                        <!-- Örneğin: <option value="1">Okul 1</option> -->
                    </select>
                </div>
                <button type="submit" class="btn btn-success shadow-none">Öğrenci Oluştur</button>
            </form>
        </div>

        <div class="col-md-9 mb-5">
            <form onsubmit="event.preventDefault(); editStudent();" class="d-flex align-items-end justify-content-between">
                <div class="col-3">
                    <label for="student_id">Öğrenci:</label>
                    <select id="student_id" name="student_id" class="form-select shadow-none" required>
                        <option value="">Öğrenci Seçin</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="name">Adı:</label>
                    <input type="text" id="name_edit" name="name" class="form-control shadow-none" required>
                </div>
                <div class="col-3">
                    <label for="school_id_uedit">Okulu:</label>
                    <select id="school_id_uedit" name="school_id_uedit" class="form-select shadow-none" required>
                        <option value="">Okul Seçin</option>
                        <!-- Okul seçeneklerini dinamik olarak burada oluşturabilirsiniz -->
                        <!-- Örneğin: <option value="1">Okul 1</option> -->
                    </select>
                </div>
                <button type="submit" class="btn btn-success shadow-none">Öğrenci Düzenle</button>
            </form>
        </div>

        <div class="col-md-9 mb-6">
                <div class="w-100">
                    <table class="table table-hover table-striped table-secondary">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Öğrenci Adı</th>
                                <th scope="col">Okul Adı</th>
                                <th scope="col">Sıra</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="ogrenci_liste">
                             <tr><td colspan="4" class="text-center">Yükleniyor..</td></tr>
                        </tbody>
                    </table>
                </div>
        </div>

        <div class="col-md-9 mb-5 mt-5">
            <form onsubmit="event.preventDefault(); createSchool();" class="d-flex align-items-end justify-content-between">
                <div class="col-4">
                    <label for="name">Okul Adı:</label>
                    <input type="text" id="name_okul" name="name" class="form-control shadow-none" required>
                </div>
                <button type="submit" class="btn btn-success shadow-none">Okul Oluştur</button>
            </form>
        </div>

        <div class="col-md-9 mb-5">
            <form onsubmit="event.preventDefault(); editSchool();" class="d-flex align-items-end justify-content-between">
                <div class="col-4">
                    <label for="school_id_edit">Okul:</label>
                    <select id="school_id_edit" name="school_id_edit" class="form-select shadow-none" required>
                        <option value="">Okul Seçin</option>
                        <!-- Okul seçeneklerini dinamik olarak burada oluşturabilirsiniz -->
                        <!-- Örneğin: <option value="1">Okul 1</option> -->
                    </select>
                </div>
                <div class="col-4">
                    <label for="name">Okul Adı:</label>
                    <input type="text" id="name_okul_edit" name="name" class="form-control shadow-none" required>
                </div>
                <button type="submit" class="btn btn-success shadow-none">Okul Düzenle</button>
            </form>
        </div>

        <div class="col-md-9">
            <div class="w-100">
                <table class="table table-hover table-striped table-secondary">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Okul Adı</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="okul_liste">
                    <tr><td colspan="3" class="text-center">Yükleniyor..</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function okulListele(){
        $.ajax({
            url: 'api/schools',
            type: 'GET',
            success: function(response) {
                if(response.success) {

                    var schools = response.data;

                    $("#school_id").html("<option value=''>Okul Seçin</option>");
                    $("#okul_liste").html('');
                    $("#school_id_edit").html("<option value=''>Okul Seçin</option>");
                    $("#school_id_uedit").html("<option value=''>Okul Seçin</option>");

                    if(schools.length > 0) {
                        $.each(schools, function(index, school) {
                            $("#school_id").append("<option value='"+school.id+"'>"+school.name+"</option>");
                            $("#school_id_uedit").append("<option value='"+school.id+"'>"+school.name+"</option>");
                            $("#school_id_edit").append("<option value='"+school.id+"'>"+school.name+"</option>");
                            $("#okul_liste").append('<tr><th scope="row">'+(index+1)+'</th><td>'+school.name+'</td><td><a href="javascript:void(0)"  class="btn btn-danger rounded-0 shadow-none float-end py-0 px-4" onclick="okulSil('+school.id+')">Sil</a></td></tr>');
                        });
                    } else {
                        $("#okul_liste").html('<tr><td colspan="3" class="text-center">Herhangi Bir Okul Verisi Bulunamadı.</td></tr>');
                    }

                }
            },
            error: function(xhr, status, error) {
                // İstek hatası durumunda yapılacak işlemler
                console.error('Listeleme işlemi başarısız oldu. Hata:', error);
            }
        });

        ogrenciListele();
    }

    function okulSil($id = null){
        if($id) {
            $.ajax({
                url: 'api/schools/' + $id,
                type: 'DELETE',
                success: function(response) {
                    // İstek başarılı olduğunda yapılacak işlemler
                    console.log('Başarıyla silindi.');
                    okulListele();

                },
                error: function(xhr, status, error) {
                    // İstek hatası durumunda yapılacak işlemler
                    console.error('Silme işlemi başarısız oldu. Hata:', error);
                }
            });


        }
    }

    function createSchool() {
        // Öğrenci bilgilerini toplayın
        var name = document.getElementById('name_okul').value;

        // Ajax isteği için veri nesnesi oluşturun
        var data = {
            name: name,
        };

        // Ajax isteği gönderme
        $.ajax({
            url: 'api/schools',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                // İstek başarılı olduğunda yapılacak işlemler
                console.log(response.message); // Başarı mesajını konsola yazdırabilirsiniz
                // Diğer işlemleri burada gerçekleştirebilirsiniz, örneğin liste yenileme vb.

                okulListele();
            },
            error: function(xhr, status, error) {
                // İstek başarısız olduğunda yapılacak işlemler
                console.error(error); // Hata mesajını konsola yazdırabilirsiniz
            }
        });
    }

    function editSchool() {
        // Öğrenci bilgilerini toplayın
        var name = document.getElementById('name_okul_edit').value;
        var school_id = document.getElementById('school_id_edit').value;

        // Ajax isteği için veri nesnesi oluşturun
        var data = {
            name: name,
        };

        // Ajax isteği gönderme
        $.ajax({
            url: 'api/schools/'+school_id,
            type: 'PUT',
            data: data,
            dataType: 'json',
            success: function(response) {
                // İstek başarılı olduğunda yapılacak işlemler
                console.log(response.message); // Başarı mesajını konsola yazdırabilirsiniz
                // Diğer işlemleri burada gerçekleştirebilirsiniz, örneğin liste yenileme vb.

                okulListele();
            },
            error: function(xhr, status, error) {
                // İstek başarısız olduğunda yapılacak işlemler
                console.error(error); // Hata mesajını konsola yazdırabilirsiniz
            }
        });
    }

    function ogrenciListele(){
        $.ajax({
            url: 'api/students',
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    $("#ogrenci_liste").html(response.html);

                    var students = response.data;

                    $("#student_id").html('<option value="">Öğrenci Seçin</option>');
                    if(students.length > 0) {
                        $.each(students, function (index, student) {
                            $("#student_id").append("<option value='"+student.id+"'>"+student.name+"</option>");
                        });
                    }

                }
            },
            error: function(xhr, status, error) {
                // İstek hatası durumunda yapılacak işlemler
                console.error('Öğrenci listeleme işlemi başarısız oldu. Hata:', error);
            }
        });
    }

    function ogrenciSil($id = null){
        if($id) {
            $.ajax({
                url: 'api/students/' + $id,
                type: 'DELETE',
                success: function(response) {
                    // İstek başarılı olduğunda yapılacak işlemler
                    console.log('Öğrenci başarıyla silindi.');
                    ogrenciListele();

                },
                error: function(xhr, status, error) {
                    // İstek hatası durumunda yapılacak işlemler
                    console.error('Öğrenci silme işlemi başarısız oldu. Hata:', error);
                }
            });


        }
    }

    function createStudent() {
        // Öğrenci bilgilerini toplayın
        var name = document.getElementById('name').value;
        var schoolId = document.getElementById('school_id').value;

        // Ajax isteği için veri nesnesi oluşturun
        var data = {
            name: name,
            school_id: schoolId
        };

        // Ajax isteği gönderme
        $.ajax({
            url: 'api/students',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                // İstek başarılı olduğunda yapılacak işlemler
                console.log(response.message); // Başarı mesajını konsola yazdırabilirsiniz
                // Diğer işlemleri burada gerçekleştirebilirsiniz, örneğin liste yenileme vb.

                ogrenciListele();
            },
            error: function(xhr, status, error) {
                // İstek başarısız olduğunda yapılacak işlemler
                console.error(error); // Hata mesajını konsola yazdırabilirsiniz
            }
        });
    }

    function editStudent() {
        // Öğrenci bilgilerini toplayın
        var id = document.getElementById('student_id').value;
        var name = document.getElementById('name_edit').value;
        var school_id = document.getElementById('school_id_uedit').value;

        // Ajax isteği için veri nesnesi oluşturun
        var data = {
            name: name,
            school_id: school_id,
        };

        // Ajax isteği gönderme
        $.ajax({
            url: 'api/students/'+id,
            type: 'PUT',
            data: data,
            dataType: 'json',
            success: function(response) {
                // İstek başarılı olduğunda yapılacak işlemler
                console.log(response.message); // Başarı mesajını konsola yazdırabilirsiniz
                // Diğer işlemleri burada gerçekleştirebilirsiniz, örneğin liste yenileme vb.

                okulListele();
            },
            error: function(xhr, status, error) {
                // İstek başarısız olduğunda yapılacak işlemler
                console.error(error); // Hata mesajını konsola yazdırabilirsiniz
            }
        });
    }


    ogrenciListele();
    okulListele();
</script>
@endsection
