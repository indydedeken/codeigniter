import org.apache.pdfbox.pdfparser.PDFStreamParser;
import org.apache.pdfbox.pdfwriter.ContentStreamWriter;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.common.PDStream;
import org.apache.pdfbox.util.PDFOperator;

import java.util.ArrayList;
import java.util.List;

public class RemoveAllText
{
    /**
     * constructeur par défaut.
     */
    private RemoveAllText()
    {
        //example class should not be instantiated
    }

    /**
     * On retire tous le texte d'un pdf
     */
    public static void main( String[] args ) throws Exception
    {
        if( args.length != 2 )
        {
            usage();
        }
        else
        {
            PDDocument document = null;
            try
            {
                document = PDDocument.load( args[0] );
                if( document.isEncrypted() )
                {
                    System.err.println( "Erreur document pas supporté pour cette manipulation." );
                    System.exit( 1 );
                }
                // On récupère toutes les pages dans une List
                List allPages = document.getDocumentCatalog().getAllPages();
                for( int i=0; i<allPages.size(); i++ )
                {
                	// On récupère page par page
                    PDPage page = (PDPage)allPages.get( i );
                    // On crée un Parser
                    PDFStreamParser parser = new PDFStreamParser(page.getContents());
                    parser.parse();
                    // On crée une Liste de 
                    List tokens = parser.getTokens();
                    // On crée une list
                    List newTokens = new ArrayList();
                    for( int j=0; j<tokens.size(); j++)
                    {
                    	
                        Object token = tokens.get( j );
                        if( token instanceof PDFOperator )
                        {
                            PDFOperator op = (PDFOperator)token;
                            if( op.getOperation().equals( "TJ") || op.getOperation().equals( "Tj" ))
                            {
                                
                                newTokens.remove( newTokens.size() -1 );
                                continue;
                            }
                        }
                        newTokens.add( token );

                    }
                    PDStream newContents = new PDStream( document );
                    ContentStreamWriter writer = new ContentStreamWriter( newContents.createOutputStream() );
                    writer.writeTokens( newTokens );
                    newContents.addCompression();
                    page.setContents( newContents );
                }
                document.save( args[1] );
            }
            finally
            {
                if( document != null )
                {
                    document.close();
                }
            }
        }
    }

    /**
     * Mode d'emploi, comment utiliser le programme
     */
    private static void usage()
    {
        System.err.println( "Mode d'emploi: RemoveAllText <pdf en Entrée> <Pdf en sortie>" );
    }

}
