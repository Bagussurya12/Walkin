
<html>

  
    
                      <table>
                      
                        <tr>
                          <td colspan="7">Download pada : </td>
                          
                        </tr>
                        <tr>
                          <td colspan="7"><b>DATA TAMU WI</b></td>
                          
                        </tr>
                        <tr>
                          <td colspan="7">PT Olympic Bangun Persada</td>
                          
                        </tr>
                        <tr>
                          <td colspan="7">Jumlah hari : {{ $total }}</td>
                          
                        </tr>
                        
                        <tr>
                          <th>No</th>
                            <th>Tgl</th>
                            <th>Nama Tamu</th>
                            <th>Sales</th>
                            <th>Sales Manager</th>
                            <th>No. Handphone</th>
                            <th>Sumber Informasi</th>
                            <th>Referensi</th>
                            <th>Tgl lahir</th>
                            <th>Umur</th>
                            <th>Jenis kelamin</th>
                            <th>Status Data</th>
                        </tr>
                      
                      @foreach ($data  as $key => $dt)
                      
                        
                        
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ date('d/m/Y', strtotime($dt->tgl)) }}</td>
                          <td>{{ $dt->nama }}</td>
                          <td>{{ $dt->name }}</td>
                          <td>{{ $dt->namaSalesManager }}
                          <td>{{ $dt->hp }}</td>
                          <td>{{ $dt->sumber }} <br>{{ $dt->sumberlain }}</td>
                          <td>{{ $dt->referensi }}</td>
                          <td>{{ date('d/m/Y', strtotime($dt->tgl_lahir)) }} </td>
                          <td>{{ $dt->umur }}</td>
                          <td>{{ $dt->jk }}</td>
                          <td>
                            @if($dt->status == '0')
                              Baru
                            @endif

                            @if($dt->status == '1')
                              Proses Lanjut
                            @endif

                            @if($dt->status == '2')
                              Closing
                            @endif

                            @if($dt->status == '3')
                              Batal
                            @endif
                          </td>
                        </tr>
                        
                      
                      
                    
                        @endforeach
                      </table>

</html>                 