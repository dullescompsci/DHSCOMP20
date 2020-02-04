import java.io.File;
import java.util.Scanner;

public class occurring_difference
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("occurring_difference.dat"));

        while(fromFile.hasNextLine()) {
            String[] textValues = fromFile.nextLine().split(" ");
            int[] values = new int[textValues.length];

            for(int x=0; x<values.length;x++)
                values[x]=Integer.parseInt(textValues[x]);


            int maxCount =numOccurrences(values[0],values);
            int minCount = maxCount;
            int maxValue = values[0];
            int minValue = values[0];

            for(int x=1; x<values.length; x++) {
                int count = numOccurrences(values[x],values);
                if(count < minCount){
                    minCount=count;
                    minValue=values[x];
                }
                else if(count > maxCount){
                    maxCount=count;
                    maxValue=values[x];
                }
            }

            System.out.println("The difference is " + Math.abs(minValue-maxValue));
        }
    }

    public static int numOccurrences(int v, int[] values)
    {
        int count=0;
        for(int value:values)
            if(value==v)
                count++;
        return count;
    }
}
