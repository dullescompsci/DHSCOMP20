import java.io.File;
import java.util.Scanner;

public class herons
{
    public static final int FEET_IN_A_MILE = 5280;

    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("herons.dat"));

        int numTri = fromFile.nextInt();
        fromFile.nextLine();
        for(int x=0; x<numTri; x++)
        {
            String[] textSides = fromFile.nextLine().split(",");
            double[] sides = {Double.parseDouble(textSides[0]),Double.parseDouble(textSides[1]),Double.parseDouble(textSides[2])};
            double s = (sides[0]+sides[1]+sides[2])/2;
            double a = Math.sqrt(s*(s-sides[0])*(s-sides[1])*(s-sides[2]));
            System.out.printf("%.3f\n",a);
        }
    }
}
