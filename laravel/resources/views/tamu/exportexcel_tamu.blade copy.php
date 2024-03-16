
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
                          <th width="5%">No</th>
                            <th>Tgl</th>
                            <th>Nama Tamu</th>
                            <th>Sales</th>
                            <th>No. Handphone</th>
                            <th>Sumber</th>
                            <th>Status Data</th>
                        </tr>
                      
                      @foreach ($data  as $dt)
                      
                        
                        
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ date('d/m/Y', strtotime($dt->tgl)) }}</td>
                          <td>{{ $dt->nama }}</td>
                          <td>{{ $dt->nama_sale->name }}</td>
                          <td>{{ $dt->hp }}</td>
                          <td>{{ $dt->sumber }}</td>
                          <td>{{ $dt->status }}</td>
                        </tr>
                        
                      
                      
                    
                        @endforeach
                      </table>

</html>                 