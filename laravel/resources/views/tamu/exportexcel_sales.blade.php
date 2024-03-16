
<html>

  
    
                      <table>
                      
                        <tr>
                          <td colspan="7">Download pada : </td>
                          
                        </tr>
                        <tr>
                          <td colspan="7"><b>DATA SALES AKTIV</b></td>
                          
                        </tr>
                        <tr>
                          <td colspan="7">PT Olympic Bangun Persada</td>
                          
                        </tr>
                       
                        
                        <tr>
                          <th>kode sales</th>
                          <th>Nama sales</th>
                        </tr>
                      
                      @foreach ($data  as $dt)
                      
                        
                        
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $dt->name }}</td>
                        </tr>
                        
                      
                      
                    
                        @endforeach
                      </table>

</html>                 