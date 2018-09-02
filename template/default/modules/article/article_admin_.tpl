<div class="left_articles">
			<fieldset>
					<legend>{$lang.article_config|default:"Konfig�racija"}</legend>
				    <form id="form1" method="post" action="">
				      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="43%"><label>
                            <input name="show_cat" type="checkbox" id="show_cat" value="show_cat" />
                          {$lang.article_show_categories|default:"Rodyti kategorijas"}</label></td>
                          <td width="57%"><label>
                            <input name="allow_vote" type="checkbox" id="allow_vote" value="allow_vote" />
                          Leisti balsuoti </label></td>
                        </tr>
                        <tr>
                          <td><label>
                            <input name="show_article" type="checkbox" id="show_article" value="show_article" />
                          Rodyti naujausius straipsnius</label></td>
                          <td><label>
                            <input name="allow_only_see_admin" type="checkbox" id="allow_only_see_admin" value="allow_only_see_admin" />
                          Straipsnis rodomas tik po administratoriaus peržiūros </label></td>
                        </tr>
                        <tr>
                          <td><label>
                            <input name="allow_send" type="checkbox" id="allow_send" value="allow_send" />
                          Leisti atsiųsti straipsnį </label></td>
                          <td><label>
                            <input name="allow_send_email" type="checkbox" id="allow_send_email" value="allow_send_email" />
                          Pranešti prenumeratorius El. Paštu apie naują straipsnį </label></td>
                        </tr>
                        <tr>
                          <td><label>
                            <input name="allow_write" type="checkbox" id="allow_write" value="allow_write" />
                          Leisti rašyti straipsnį svetainėje </label></td>
                          <td><label></label></td>
                        </tr>
                        <tr>
                          <td><label>
                            <input name="allow_show_url" type="checkbox" id="allow_show_url" value="allow_show_url" />
                          Leisti straipsnių siuntimą paštu</label></td>
                          <td>
Kiek puslapyje rodyti straipsnių?
                            <label>
<select name="select" class="date">
  <option>5</option>
  <option>10</option>
  <option>15</option>
  <option>20</option>
  <option>25</option>
  <option>30</option>
  <option>40</option>
  <option>50</option>
</select>
</label></td>
                        </tr>
                        <tr>
                          <td><label>
                            <input name="allow_comment" type="checkbox" id="allow_comment" value="allow_comment" />
                          Leisti komentuoti straipsnį</label></td>
                          <td>
				    Straipsnius rykiuoti pagal
                            <label>
                            <select name="select2" class="date">
                              <option>Lankomumą</option>
                              <option>Balsavimą</option>
                              <option>Nuo naujausio iki Seniausio</option>
                              <option>Nuo Seniausio iki Naujausio</option>
                              <option>Datą</option>
                              <option>Abecelės tvarka</option>
                            </select>
                          </label></td>
                        </tr>
                      </table>
            </form>
			    </fieldset>
		  </h2>
		  <p>&nbsp;</p>
		  </div>
	