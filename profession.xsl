<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="yrker">

<html>
    <head>
        <title>TestSide</title>
    </head>
    <body>
      <h1>Yrker</h1>
        <xsl:for-each select="yrker">
          
          <table>
            <tr><th>Yrkestittel</th><th>Yrkesbeskrivelse</th>

              <tr>

                <td><xsl:value-of select="yrkesTittel" /></td>
                <td><xsl:value-of select="yrkesBeskrivelse" /></td>
                
              </tr>
            </xsl:for-each>
          </table>
        </xsl:for-each>
    </body>
  </html>
</xsl:template>

</xsl:stylesheet>
