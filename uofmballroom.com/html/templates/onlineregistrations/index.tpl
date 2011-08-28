{include file='header.tpl' lightbox=true}

	<div id="leftContainer">
		<table>
        	<tr bgcolor="black" style="color:white;">
            	<td>First</td>
                <td>Last</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Car</td>
                <td>Boombox</td>
                <td>ethnicity</td>
                <td>hear about us</td>
                <td>school</td>
                <td style='width:100px; float:left;'>time</td>
            </tr>
            
            {foreach from=$registrants item=registrant}
            <tr>
            	<td>{$registrant.first_name}</td>
                <td>{$registrant.last_name}</td>
                <td>{$registrant.email}</td>
                <td>{$registrant.phone}</td>
            	<td>{$registrant.car}</td>
                <td>{$registrant.boombox}</td>
                <td>{$registrant.ethnicity}</td>
            	<td>{$registrant.hear_about_us}</td>
                <td>{$registrant.school}</td>
                <td>{$registrant.ts_created|date_format}</td>
            </tr>
            {/foreach}
        
        </table>

	</div>
    
{include file='footer.tpl'}